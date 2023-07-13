<x-layouts.dashboard>
    <style> 
        /* Add custom styles here */
        .card-header {
            background-color: #6c757d;
            color: #fff;
            text-align: center;
            padding: 1rem;
        }

        .notification-link:hover {
            text-decoration: underline;
        }

        .alert-info {
            border-color: #17a2b8;
            background-color: #f1f8ff;
            color: #0c5460;
        }
    </style>
    <div class="container my-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Notifications</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($notifications as $notification)
                        <div class="alert alert-info" role="alert">
                            <a href="{{ route('user.tasks') }}" class="text-dark font-weight-bold notification-link">{{
                                $notification->subject }}</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
<!-- Include Bootstrap JS and other scripts if needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"
    integrity="sha512-+Q/OoY6vWb+HS4JrQgI9KU6Ov3GyC9zmcQYJlWcHhF2N6m+z3sN0YqCs9Yr6Bn0HxS7e9uZL6yFzZg8jzqQ3xg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>