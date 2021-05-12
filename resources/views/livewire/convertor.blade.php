<div class="container mx-auto ">

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if ($converting)
        <div class="text-center py-15" >
            @include('svg.loading')
            <p class="mt-3">Converting...</p>
        </div>
    @endif

    @if ($uploading)
        <div class="text-center py-15">
            @include('svg.loading')
            <p class="mt-3">Uploading...</p>
        </div>
    @endif


    @error('newfiles') <span class="error">{{ $message }}</span> @enderror

    <form>

        <div class="g-recaptcha d-inline-block" data-sitekey="{{ config('convertor.captcha.site_key') }}"
            data-callback="recaptchaCallback" data-size="invisible" wire:ignore></div>

    </form>


    @if (count($files) && !$isFinished && !$converting && !$uploading)
        <table wire:loading.remove wire:target="convert"
            class="mx-auto max-w-4xl w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden mt-10 rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blu">

            <tbody class="divide-y divide-gray-200">
                @foreach ($files as $key => $file)
                    <tr>
                        <td class="px-6 py-4">
                            {{ $file->getClientOriginalName() }} -
                            {{ App\Services\Helper::formatBytes($file->getSize()) }}

                        </td>


                        <td class="px-6 py-4 text-center">
                            <a wire:click="delete({{ $key }})" class="text-red-800 hover:underline">Delete</a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    @endif




    <form enctype="multipart/form-data" wire:loading.remove wire:target="convert">



        @if ($isFinished && !$converting && !$uploading)
            <div class="flex w-full pt-24 pb-10 items-center justify-center bg-grey-lighter">
                <button wire:click.prevent="download"
                    class="w-64 flex flex-col items-center px-4 py-6 bg-green-400 text-white rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-gray-800">
                    @include('svg.download')
                    <span class="mt-2 text-base leading-normal">Download</span>
                </button>
            </div>

            <div class="flex justify-center pb-24">
                <a href="{{ route('convertor.page', ['type' => $currentType]) }}" class="flex items-center">
                    @include('svg.reset') <span class="ml-2">Convert more</span></a>
            </div>

        @elseif(!$converting && !$uploading)
            @if (count($files))
                <div class="flex py-10">
                    @if (count($files) < config('app.max_files_allowed'))
                        <div class="flex-auto">
                            <div class="flex items-center justify-center bg-grey-lighter">
                                <div>
                                    <label
                                    class="w-64 flex flex-col items-center px-4 py-6 bg-gray-800 text-white rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer ">
                                    @include('svg.select_file')
                                    <span class="mt-2 text-base leading-normal">Select a file</span>
                                    <input type="file" wire:model="newfiles" multiple class="hidden"
                                        onchange="recaptchaCallback()" accept="{{ $config['mimes'] }}">
                                </label>
                                @if (count($files))
                                <p class="text-center font-bold text-sm">{{config('app.max_files_allowed')}} files maximum<p>
                                @endif
                                </div>

                            </div>
                        </div>
                    @endif
                    <div class="flex-auto">
                        <div class="flex items-center justify-center ">
                            <button wire:click.prevent="convert" 
                                class="w-64 flex flex-col items-center px-4 py-6 bg-green-400 text-white rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer  ">
                                @include('svg.convert')

                                <span class="mt-2 text-base leading-normal">Convert</span>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex w-full py-24 items-center justify-center bg-grey-lighter">
                    <div>
                        <label
                        class="w-64 flex flex-col items-center px-4 py-6 bg-gray-800 text-white rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer ">
                        @include('svg.select_file')
                        <span class="mt-2 text-base leading-normal">Select a file</span>
                        <input type="file" wire:model="newfiles" multiple class="hidden" onchange="recaptchaCallback()"
                            accept="{{ $config['mimes'] }}">
                        </label>
                        @if (count($files))
                        <p class="text-center font-bold text-sm">{{config('app.max_files_allowed')}} files maximum<p>
                        @endif
                    </div>

                </div>

            @endif
        @endif


    </form>
    {{-- @error('newfiles.*') <span class="error">{{ $message }}</span> @enderror --}}



</div>



<script src="https://www.google.com/recaptcha/api.js?render={{ config('convertor.captcha.site_key') }}"></script>
<script>
    var recaptchaCallback = function() {
        @this.set('uploading', true);
        grecaptcha.execute('{{ config('convertor.captcha.site_key') }}', {
                action: 'validate_captcha'
            })
            .then(function(token) {
                @this.set('recaptcha_response', token);
         
            });
    }



    document.addEventListener('livewire:load', function() {





        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "slideDown",
            "hideMethod": "slideUp",
            "tapToDismiss": false
        };

        Livewire.on('showAlert', data => {
            toastr[data.type](data.message, data.title);
            // console.log(message, type);
        });

        Livewire.on('reCaptcha', () => {
            // recaptchaCallback();
        });



        window.Echo.channel('laravel_database_converts-{{ $storageFolder->id }}')
            .listen('ConvertStatusUpdateEcho', (e) => {
                console.log(e);
            });

    });

</script>
