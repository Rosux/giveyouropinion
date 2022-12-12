<x-layout>
    <link rel="stylesheet" href="{{ asset("styles/home.css") }}">
    <div class="landing-full">
        <div class="landing-full-darken">
            <p class="landing-title">Give Your Opinion!<br><a class="small">Anonymously</a></p>
        </div>
    </div>
    <div class="wrapper-center">
        <h2 class="title">Start Your Form Right Here</h2>
        {{-- if logged in make button go to create form page else login/register page --}}
        <button>Create New Form</button>
    </div>
</x-layout>