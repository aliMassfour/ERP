<x-layouts.dashboard>
    <style>
        .fa-star {
            font-size: 24px;
        }
    </style>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3" >
                <div class="card-header">
                    <h5 class="card-title">Best Employee of the Month</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Role:</strong> {{ $user->role->name }}</p>
                    <div>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star" checked></span>
                        <span class="fa fa-star" checked></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard>