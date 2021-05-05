<div class="container mx-auto ">

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div wire:loading.block wire:target="convert" class="text-center py-15">
        @include('svg.loading')
        <p class="mt-3">Converting...</p>
    </div>

    <div wire:loading.block wire:target="newfiles" class="text-center py-15">
        @include('svg.loading')
        <p class="mt-3">Uploading...</p>
    </div>


    @error('newfiles') <span class="error">{{ $message }}</span> @enderror


    @if (count($files) && !$isFinished)
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

        @if ($isFinished)
            <div class="flex w-full pt-24 pb-10 items-center justify-center bg-grey-lighter">
                <button wire:click.prevent="download"
                    class="w-64 flex flex-col items-center px-4 py-6 bg-green-400 text-white rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-gray-800">
                    @include('svg.download')
                    <span class="mt-2 text-base leading-normal">Download</span>
                </button>
            </div>

            <div class="flex justify-center pb-24">
                <button wire:click.prevent="refresh" class="flex items-center"> @include('svg.reset') <span
                        class="ml-2">Convert more</span></button>
            </div>

        @else
            @if (count($files))
                <div class="flex py-10">
                    @if (count($files) < config('app.max_files_allowed'))
                    <div class="flex-auto">
                        <div class="flex items-center justify-center bg-grey-lighter">
                            <label
                                class="w-64 flex flex-col items-center px-4 py-6 bg-gray-800 text-white rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer ">
                                @include('svg.select_file')
                                <span class="mt-2 text-base leading-normal">Select a file</span>
                                <input type="file" wire:model="newfiles" multiple class="hidden"
                                    accept="{{ $config['mimes'] }}">
                            </label>
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
            <div class="flex w-full py-24 items-center justify-center bg-grey-lighter" wire:loading.remove
                    wire:target="newfiles">
                    <label
                        class="w-64 flex flex-col items-center px-4 py-6 bg-gray-800 text-white rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer ">
                        @include('svg.select_file')
                        <span class="mt-2 text-base leading-normal">Select a file</span>
                        <input type="file" wire:model="newfiles" multiple class="hidden"
                            accept="{{ $config['mimes'] }}">
                    </label>
                </div>
            @endif
        @endif


    </form>
    {{-- @error('newfiles.*') <span class="error">{{ $message }}</span> @enderror --}}



</div>


<script>
    document.addEventListener('livewire:load', function() {
        

    // });
    toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-center",
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
            toastr[data.type]( data.message, data.title);
            // console.log(message, type);
        });

    });
</script>
