<x-layouts.user.app title="Home">

    <section id="hero">
        <div class="container col-xxl-8 px-4 py-5">
            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                <div class="col-10 col-sm-8 col-lg-6">
                    <img src="{{ asset('assets/images/hero_image.jpg') }}" class="d-block mx-lg-auto img-fluid"
                        alt="Bootstrap Themes" width="700" height="500" loading="lazy">
                </div>
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">MMRC Tailoring</h1>
                    <p class="lead">Where you can effortlessly schedule your ultimate fitting experience and explore
                        personalized
                        tailoring services tailored just for you!</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        @auth
                            @if (auth()->user()->role === 'user')
                                <a href="{{ route('user.appointment.index') }}" class="btn btn-primary btn-lg px-4 me-md-2">
                                    <i class="bi bi-calendar-check"></i> Make an Appointment
                                </a>
                                <a href="#" class="btn btn-secondary btn-lg px-4 me-md-2 orderNow">
                                    <i class="bi bi-cart"></i> Order Now
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-md-2">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-secondary btn-lg px-4 me-md-2">
                                <i class="bi bi-person-plus"></i> Register
                            </a>
                        @endauth
                        {{-- <a href="{{ route('user.order.index') }}" class="btn btn-outline-secondary btn-lg px-4">Order Now</a> --}}
                        {{-- <div class="btn-group">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Order Now
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('user.order.index',['order_type' => 'customized']) }}">Customized</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.order.index',['order_type' => 'ready_made']) }}">Ready Made</a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="choose-us">
        <div class="container px-4 py-5">
            <h1 class="text-center mb-4">Why choose us?</h1>
            <div class="d-flex justify-content-around align-items-center">
                <div class="flex-column">
                    <x-choose-us-left>
                        <x-slot name="title">Affordable Cost</x-slot>
                        <x-slot name="body">At MMRC Tailoring, we speciallize in delivering<br> top-quality,
                            budget-friendly
                            school uniforms that<br>
                            won't strain your finances.
                        </x-slot>

                        <x-slot name="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 63.89">
                                <path
                                    d="M0 0h122.88v63.89H0V0zm61.46 13.16c10.4 0 18.8 8.41 18.8 18.8 0 10.4-8.41 18.8-18.8 18.8-10.4 0-18.8-8.41-18.8-18.8s8.4-18.8 18.8-18.8zm2.32 23.67c0-.74-.18-1.33-.55-1.73-.37-.41-1-.81-1.92-1.18-.92-.37-1.77-.74-2.54-1.14-.77-.37-1.44-.85-2.03-1.33-.55-.52-1-1.11-1.29-1.77-.29-.66-.44-1.47-.44-2.43 0-1.59.52-2.88 1.59-3.91 1.07-1.03 2.51-1.62 4.28-1.81v-2.14h2.25v2.18c1.7.26 3.06.96 4.06 2.1s1.47 2.62 1.47 4.39H63.9c0-.96-.18-1.73-.55-2.25-.37-.52-.92-.77-1.59-.77-.63 0-1.11.18-1.44.59-.33.41-.52.92-.52 1.62s.18 1.25.59 1.66c.41.41 1.03.81 1.88 1.18.88.37 1.7.74 2.47 1.14.77.41 1.44.85 1.99 1.36s1 1.11 1.33 1.77c.33.66.48 1.47.48 2.43 0 1.59-.52 2.91-1.51 3.91-1.03 1-2.4 1.59-4.17 1.77v1.99h-2.25v-1.99c-2.03-.22-3.61-.92-4.72-2.1-1.11-1.18-1.66-2.77-1.66-4.68h4.76c0 1.07.22 1.88.7 2.43.48.55 1.14.85 2.03.85.63 0 1.14-.18 1.51-.55.37-.37.55-.88.55-1.55v-.04zM20.54 9.73h81.7c0 5.2 4.24 9.44 9.44 9.44v25.25c-5.2 0-9.44 4.24-9.44 9.44h-81.7c0-5.2-4.24-9.44-9.44-9.44V19.17c5.2 0 9.44-4.24 9.44-9.44z"
                                    fill-rule="evenodd" fill="#FFF" clip-rule="evenodd" />
                            </svg></x-slot>
                    </x-choose-us-left>

                    <x-choose-us-left icon="">
                        <x-slot name="title">Convenient Online Measurement and Booking</x-slot>
                        <x-slot name="body">Our user-friendly platforms makes it easy to book<br> appointments and
                            provide
                            measurement online,<br> saving you time and hussle. Whether you want<br> to schedule a face
                            to
                            face fitting or submit <br>measurements digitally, we ensure seamless, <br>stress-free
                            process.
                        </x-slot>
                        <x-slot name="icon">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 96.42 122.88"
                                style="enable-background:new 0 0 96.42 122.88" xml:space="preserve">
                                <style type="text/css">
                                    .st0 {
                                        fill-rule: evenodd;
                                        clip-rule: evenodd;
                                    }
                                </style>
                                <g>
                                    <path class="st0" fill="#FFF"
                                        d="M17.14,0h62.14C84,0,88.32,1.94,91.4,5.02c3.13,3.13,5.02,7.4,5.02,12.12c0,37.1,0,51.51,0,88.61 c0,4.72-1.89,8.99-5.02,12.12c-3.08,3.08-7.4,5.02-12.12,5.02H17.14c-4.72,0-8.99-1.89-12.12-5.02C1.94,114.78,0,110.46,0,105.74 c0-37.1,0-51.5,0-88.61C0,12.42,1.94,8.1,5.02,5.02C8.15,1.89,12.42,0,17.14,0L17.14,0z M45.14,60.23h0.27 c2.12,0,3.87,1.75,3.87,3.87v24.84h2.51V78.52c0-1.97,1.62-3.59,3.59-3.59h0.27c2.12,0,3.87,1.75,3.87,3.86v10.39l0.12-0.05h2.71 v-7.9c0-1.97,1.62-3.59,3.59-3.59h0.27c2.12,0,3.87,1.75,3.87,3.86v7.24h0.02l2.68-0.02v-5.12c0-1.97,1.62-3.59,3.59-3.59h0.27 c2.12,0,3.87,1.75,3.87,3.86v10.83c0,0.12,0,0.27-0.02,0.39l0.12,0.1c0.1,2.96,0.08,6.46-0.43,9.9h9.43c0-35.4,0-52.83,0-88.23 H6.76c0,35.4,0,52.83,0,88.23h31.75L26.16,85.51c-0.79-1.85-0.69-3.1,0.1-3.91c3.4-2.22,8.96,2.49,15.12,9.13l0.22-0.05V63.77 c0-1.97,1.62-3.59,3.59-3.59L45.14,60.23L45.14,60.23z M47.48,49.86c0,1.06-0.86,1.9-1.9,1.9c-1.06,0-1.9-0.86-1.9-1.9v-7.66 c0-1.06,0.86-1.9,1.9-1.9c1.06,0,1.9,0.86,1.9,1.9V49.86L47.48,49.86L47.48,49.86z M30.2,65.54c1.06,0,1.9,0.86,1.9,1.9 c0,1.06-0.86,1.9-1.9,1.9h-7.66c-1.06,0-1.9-0.86-1.9-1.9c0-1.06,0.86-1.9,1.9-1.9H30.2L30.2,65.54z M35.61,54.2 c0.74,0.74,0.74,1.94,0,2.68c-0.74,0.74-1.94,0.74-2.68,0l-5.39-5.42c-0.74-0.74-0.74-1.94,0-2.68c0.74-0.74,1.94-0.74,2.68,0 L35.61,54.2L35.61,54.2z M60.58,69.34c-1.06,0-1.9-0.86-1.9-1.9c0-1.06,0.86-1.9,1.9-1.9h7.66c1.06,0,1.9,0.86,1.9,1.9 c0,1.06-0.86,1.9-1.9,1.9H60.58L60.58,69.34z M57.84,56.46c-0.74,0.74-1.95,0.74-2.68,0s-0.74-1.94,0-2.68l5.39-5.42 c0.74-0.74,1.94-0.74,2.68,0c0.74,0.74,0.74,1.95,0,2.68L57.84,56.46L57.84,56.46z" />
                                </g>
                            </svg>
                        </x-slot>
                    </x-choose-us-left>
                    <x-choose-us-left icon="">
                        <x-slot name="title">Fast Turnaround Time for Uniform Orders</x-slot>
                        <x-slot name="body">At MMRC Tailoring, we understand the urgency<br> of school uniform needs.
                            That's why
                            we<br> prioritize quick, efficient service without <br>compromising on quality. With our
                            streamlined <br>production process, you'll receive your custom-<br>fitted uniforms in no
                            time,
                            ensuring students are <br>always ready for the school year.
                        </x-slot>
                        <x-slot name="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision"
                                text-rendering="geometricPrecision" image-rendering="optimizeQuality"
                                fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 471 512.35">
                                <path fill="#FFF"
                                    d="M452.29 28.07c22.24 26.03 24.09 64.87 8.55 101.96C423.41 86 380.19 47.89 332.57 15.22c44.8-21.96 93.04-18.39 119.72 12.85zm-199.92 184.6a35.661 35.661 0 0 1 15.01 15.52l63.02-1.1c9.28-.17 16.94 7.22 17.11 16.51.15 9.28-7.24 16.94-16.52 17.11l-64.76 1.13c-6.16 10.54-17.59 17.63-30.68 17.63-19.61 0-35.51-15.91-35.51-35.52 0-13.53 7.57-25.29 18.7-31.28l.01-95.87c0-9.29 7.51-16.82 16.8-16.82 9.29 0 16.82 7.53 16.82 16.82v95.87zM383.62 95.89c37.89 37.89 61.32 90.25 61.32 148.06 0 57.82-23.43 110.17-61.32 148.06-37.9 37.9-90.25 61.34-148.07 61.34-57.82 0-110.16-23.44-148.06-61.34-37.89-37.89-61.32-90.24-61.32-148.06 0-57.82 23.44-110.17 61.32-148.06 33.95-33.94 79.5-56.26 130.18-60.57 15.32-1.31 31.09-.9 46.28 1.16 46.46 6.3 88.08 27.83 119.67 59.41zM91.05 425.46l49.51 33.15-27.13 40.52c-9.16 13.67-27.67 17.33-41.34 8.18-13.67-9.16-17.32-27.65-8.17-41.33l27.13-40.52zm316.14 40.52c9.16 13.68 5.51 32.17-8.17 41.33-13.67 9.15-32.18 5.49-41.34-8.18l-27.13-40.52 49.51-33.15 27.13 40.52zM19.06 27.36C46.24-4.47 95.39-8.11 141.05 14.27 92.53 47.56 48.48 86.38 10.36 131.25-5.48 93.46-3.6 53.88 19.06 27.36z" />
                            </svg>
                        </x-slot>
                    </x-choose-us-left>
                </div>

                <img src="{{ asset('assets/images/shop.jpg') }}" class="shop-image" alt="">
            </div>
        </div>
    </section>

    {{-- <section id="services">
        <div class="container px-4 py-5">
            <h1 class="text-center mb-4">Our Services</h1>
            <div class="d-flex justify-content-around align-items-center">
                <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm">
                            <div class="card-header py-3">
                                <h4 class="my-0 fw-normal">Free</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">$0<small
                                        class="text-body-secondary fw-light">/mo</small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>10 users included</li>
                                    <li>2 GB of storage</li>
                                    <li>Email support</li>
                                    <li>Help center access</li>
                                </ul>
                                <button type="button" class="w-100 btn btn-lg btn-outline-primary">Sign up for
                                    free</button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm">
                            <div class="card-header py-3">
                                <h4 class="my-0 fw-normal">Pro</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">$15<small
                                        class="text-body-secondary fw-light">/mo</small>
                                </h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>20 users included</li>
                                    <li>10 GB of storage</li>
                                    <li>Priority email support</li>
                                    <li>Help center access</li>
                                </ul>
                                <button type="button" class="w-100 btn btn-lg btn-primary">Get started</button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm border-primary">
                            <div class="card-header py-3 text-bg-primary border-primary">
                                <h4 class="my-0 fw-normal">Enterprise</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">$29<small
                                        class="text-body-secondary fw-light">/mo</small>
                                </h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>30 users included</li>
                                    <li>15 GB of storage</li>
                                    <li>Phone and email support</li>
                                    <li>Help center access</li>
                                </ul>
                                <button type="button" class="w-100 btn btn-lg btn-primary">Contact us</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
</x-layouts.user.app>
