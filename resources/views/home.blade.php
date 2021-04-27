@extends('layouts.frontend')

@section('content')

    <!-- This is an example component -->
    <div>
        <section class=" text-gray-200 bg-gray-900">
            <div class="max-w-6xl mx-auto px-5 py-24 ">
                <div class="flex flex-wrap w-full mb-20 flex-col items-center text-center">
                    <h1 class=" title-font mb-2 text-4xl font-extrabold leading-10 tracking-tight text-left sm:text-5xl sm:leading-none md:text-6xl">
                        File Converter</h1>
                    <p class="lg:w-1/2 w-full leading-relaxed text-base">
                        ConvertApp is an online file converter. Right now support Docx and Doc conversion to image
                        format. To get started, use the button below and select files to convert from your computer.
                    </p>
                </div>
                <div class="flex flex-wrap -m-4">
                    <div class="xl:w-1/3 md:w-1/2 p-4">
                        <div class="border border-gray-300 p-6 rounded-lg">
{{--                            <div--}}
{{--                                class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">--}}
{{--                                <svg class=" fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg"--}}
{{--                                     viewBox="0 0 384 512">--}}
{{--                                    <path--}}
{{--                                        d="M0 32l34.9 395.8L191.5 480l157.6-52.2L384 32H0zm308.2 127.9H124.4l4.1 49.4h175.6l-13.6 148.4-97.9 27v.3h-1.1l-98.7-27.3-6-75.8h47.7L138 320l53.5 14.5 53.7-14.5 6-62.2H84.3L71.5 112.2h241.1l-4.4 47.7z"/>--}}
{{--                                </svg>--}}
{{--                            </div>--}}
                            <h2 class="text-lg  font-medium title-font mb-2">Data Security</h2>
                            <p class="leading-relaxed text-base">
                                ConvertApp has been trusted by our users and customers. No one except you will ever have
                                access to your files. We earn money by selling access to our API, not by selling your
                                data. Read more about that in our Privacy Policy.
                            </p>

                        </div>
                    </div>

                    <div class="xl:w-1/3 md:w-1/2 p-4">
                        <div class="border border-gray-300 p-6 rounded-lg">
{{--                            <div--}}
{{--                                class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4 italic">--}}
{{--                                    <span class="font-bold text-sm ">--}}
{{--                                      Php--}}
{{--                                    </span>--}}
{{--                            </div>--}}
                            <h2 class="text-lg  font-medium title-font mb-2">High-Quality Conversions</h2>
                            <p class="leading-relaxed text-base">
                                Besides using open source software under the hood, we’ve partnered with various software
                                vendors
                                to provide the best possible results.
                                Most conversion types can be adjusted to your needs such as setting the quality and many
                                other options.
                            </p>

                        </div>
                    </div>
                    <div class="xl:w-1/3 md:w-1/2 p-4">
                        <div class="border border-gray-300 p-6 rounded-lg">
{{--                            <div--}}
{{--                                class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">--}}
{{--                                <svg class=" fill-current h-6 w-6 " viewBox="0 0 24 24"--}}
{{--                                     xmlns="http://www.w3.org/2000/svg"><title>CSS3 icon</title>--}}
{{--                                    <path--}}
{{--                                        d="M1.5 0h21l-1.91 21.563L11.977 24l-8.565-2.438L1.5 0zm17.09 4.413L5.41 4.41l.213 2.622 10.125.002-.255 2.716h-6.64l.24 2.573h6.182l-.366 3.523-2.91.804-2.956-.81-.188-2.11h-2.61l.29 3.855L12 19.288l5.373-1.53L18.59 4.414z"/>--}}
{{--                                </svg>--}}
{{--                            </div>--}}
                            <h2 class="text-lg  font-medium title-font mb-2"> Formats Supported</h2>
                            <p class="leading-relaxed text-base">
                                ConvertApp is your Swiss army knife for file conversions.
                                Right now we support only Doc and Docx conversion.
                                Soon we will support nearly all audio, video, document, ebook, archive, image,
                                spreadsheet, and presentation formats.
                            </p>


                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{--        =================== file uploader ==============================--}}
        <livewire:fileupload />
        {{--        =================== file uploader ==============================--}}

    </div>


@endsection
