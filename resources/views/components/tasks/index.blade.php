<x-layouts.dashboard>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <style>
        .rating {
            display: inline-block;
        }

        .rating input {
            display: none;
        }

        .rating label {
            color: #ddd;
            font-size: 2.5rem;
            padding: 0 0.1rem;
            transition: color 0.2s;
            cursor: pointer;
        }

        .rating label:hover,
        .rating label:hover~label,
        .rating input:checked~label {
            color: #f2b01e;
        }
    </style>
    <x-slot name="style">
        <style>
            css Copy .form-control-file {
                font-size: 16px;
                color: #333;
                background-color: #f8f9fa;
                border-radius: 5px;
                padding: 10px;
                border: 1px solid #ced4da;
            }

            .form-control-file:focus {
                outline: none;
                border-color: #80bdff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }

            .order-card {
                border: 1px solid #CCC;
                border-radius: 10px;
                padding: 10px;
                margin: 10px auto;
            }

            .status,
            .paid,
            .not-paid {
                width: 80px;
                text-align: center;
                border-radius: 8px;
                margin: 3px;
                line-height: 19px;
            }

            .pending {
                background: #ffc107;
            }

            .completed,
            .paid {
                background: #28a745;
                color: white;
            }

            .rejected,
            .not-paid {
                background: #dc3545;
                color: white;
            }

            .order-num {
                font-size: 25px;
                font-weight: 900;
            }

            .price {
                font-size: 20px;
                margin-left: auto;
                margin-right: 10px;
                font-weight: 900;
            }

            .captin {
                font-size: 16px;
            }

            .btn-details {
                padding: 5px 10px;
            }


            .order-table {
                width: 100%;
            }

            .order-table tr {
                border-bottom: 1px solid #CCC;
            }

            .order-table td {
                padding: 5px;
            }

            .order-table td:not(:first-child) {
                text-align: center;
            }

            .order-table th {
                padding-top: 10px;
                text-align: center;
            }

            .order-table img {
                margin: 0 10px;
                object-fit: contain;
                border: 1px solid #CCC;
                border-radius: 5px;
                background: transparent;
            }

            .order-table input {
                border: 1px solid #CCC;
                width: 100px;
                text-align: right;
                padding-right: 55px;
                direction: rtl;
            }

            .page-item.active .page-link {
                background-color: #012951;
                border-color: #012951;
            }

            .page-link {
                color: #012951;
            }
        </style>

    </x-slot>
    @if(sizeOf($tasks)>0)
    @foreach ($tasks as $task)

    <div class="row">

        <div class="col-md-6 ">
            <div class="order-card">
                <div class="d-flex" style="align-items: center;justify-content: space-between;">
                    <div class="order-num"> #task{{ $task->id }}</div>
                    <div class="d-flex">
                        name : {{ $task->name }}
                        description : {{ $task->description }}
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button type="button" data-toggle="modal" rel="tooltip" class="btn btn-success"
                        onclick="show({{ json_encode($task)  }})">
                        show count down time
                    </button>
                    @if(auth()->user()->role->name=='employee')
                    <button type="button" class="btn bts-success"
                        onclick="report({{ json_encode($task) }})">report</button>
                    @endif
                    @if(auth()->user()->role->name=='admin')
                    <div class="btn-group">
                        <a href="#" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Actions</a>
                        <div class="dropdown-menu">
                            <form action="{{ route('task.destroy',$task->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button class="dropdown-item" type="submit">delete</button>
                            </form>
                            <a class="dropdown-item" href="{{ route('task.report.download',$task->id) }}">download
                                report</a>
                            <button class="dropdown-item" onclick="ev({{ json_encode($task) }})">evaluate</button>

                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="evaluateModal{{ $task->id }}" tabindex="-1" role="dialog"
        aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Evaluation
                </div>
                <div class="modal-body">
                    <form action="{{ route('task.accept',$task) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="rating">Rating:</label>
                            <div class="rating">
                                <input type="radio" name="rating" id="rating-5{{ $task->id }}" value="5"><label
                                    for="rating-5{{ $task->id }}">5</label>
                                <input type="radio" name="rating" id="rating-4{{ $task->id }}" value="4"><label
                                    for="rating-4{{ $task->id }}">4</label>
                                <input type="radio" name="rating" id="rating-3{{ $task->id }}" value="3"><label
                                    for="rating-3{{ $task->id }}">3</label>
                                <input type="radio" name="rating" id="rating-2{{ $task->id }}" value="2"><label
                                    for="rating-2{{ $task->id }}">2</label>
                                <input type="radio" name="rating" id="rating-1{{ $task->id }}" value="1"><label
                                    for="rating-1{{ $task->id }}">1</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn success">evaluate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reportModal{{ $task->id }}" tabindex="-1" role="dialog"
        aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Task Report
                </div>
                <div class="modal-body">
                    <form action="{{    route('task.report',$task->id)  }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="report{{ $task->id }}">report</label>
                            <input type="file" id="report{{ $task->id }}" class="form-control-file" name="report">
                        </div>
                        <button type="submit" class="btn btn-success">report</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- time count --}}
    <div class="modal fade" id="exampleModal{{ $task->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                </div>
                <div class="modal-body">
                    <div id="countdown-timer{{ $task->id }}">
                        <div class="row">
                            <div class="col">
                                <div class="countdown-timer-item">
                                    <span id="days{{ $task->id }}"></span>
                                    <br>Days
                                </div>
                            </div>
                            <div class="col">
                                <div class="countdown-timer-item">
                                    <span id="hours{{ $task->id }}"></span>
                                    <br>Hours
                                </div>
                            </div>
                            <div class="col">
                                <div class="countdown-timer-item">
                                    <span id="minutes{{ $task->id }}"></span>
                                    <br>Minutes
                                </div>
                            </div>
                            <div class="col">
                                <div class="countdown-timer-item">
                                    <span id="seconds{{ $task->id }}"></span>
                                    <br>Seconds
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <h2 class="h2">there is no tasks for this user</h2>
    @php
    $task = (object) [
    'name' => null,
    'deadline' => null
    ];
    @endphp
    @endif

    <script>
        // this script is for report modal
        function report(task){
            console.log(task);
            $('#reportModal'+task.id).modal('show');
        }
    </script>
    <script>
        function ev(task){
        console.log(task);
        $('#evaluateModal'+task.id).modal('show');
    }
    </script>
    <script>
        function show(task) {
   // Show the modal
   $('#exampleModal' +task.id).modal('show');
    console.log(task);
    if(task.deadline !=null){
        var countDownDate = new Date(task.deadline).getTime();
        var x = setInterval(function() {

    // Get the current date and time
    var now = new Date().getTime();

    // Calculate the remaining time
    var distance = countDownDate - now;
    console.log(distance);
    // If the countdown is finished, display a message
    if (distance < 0) {
    clearInterval(x);
    document.getElementById("countdown-timer"+task.id).innerHTML = "EXPIRED";
    }
    // Calculate days, hours, minutes, and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the countdown values in the HTML elements
    document.getElementById("days"+task.id).innerHTML = days;
    document.getElementById("hours"+task.id).innerHTML = hours;
    document.getElementById("minutes"+task.id).innerHTML = minutes;
    document.getElementById("seconds"+task.id).innerHTML = seconds;


    }, 1000);
        }
        

  
   

}
    </script>
</x-layouts.dashboard>