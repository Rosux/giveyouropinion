<x-layout>
    <link rel="stylesheet" href="{{ asset("styles/home.css") }}">
    <div class="landing-full">
        <div class="landing-full-darken">
            <p class="landing-title">Give Your Opinion!<br><a class="small">Anonymously</a></p>
        </div>
    </div>
    <div class="wrapper-center">
        <h2 class="title">Create your own form</h2>
        {{-- if logged in make button go to create form page else login/register page --}}
        <button>Create New Form</button>
    </div>
    <div class="hr-main"></div>
    <div class="wrapper-center theme-bg-dark">
        <h2 class="title">About GYO</h2>
        <div class="how-to-wrapper">
            <div class="how-to-card">
                <p class="how-to-step-counter">How does it work</p>
                <p class="how-to-desc">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis voluptas praesentium voluptatum explicabo doloribus, earum nisi commodi, perspiciatis et nobis accusamus autem iure culpa necessitatibus quae minus. Blanditiis, voluptatibus obcaecati.
                </p>
            </div>
        </div>
    </div>
</x-layout>