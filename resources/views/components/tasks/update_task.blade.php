<x-layouts.dashboard>
<div class="row">
    <form action="{{ route('task.update',$task) }}" method="POSt">
        @csrf
        @method('put')
        <div class="col-md-6">
            <div class="form-group">
                <label for="description">enter description</label>
                <br>
                <textarea value="{{ $task->description }}" name="description" id="description" cols="3100" rows="1"
                    class="form-control @if ($errors->has('description'))
                    is-invalid                        
                @endif"></textarea>
                @if ($errors->has('description'))
                <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="name">enter task name</label>

                <input value="{{ $task->name }}" type="text" name="name" class="form-control @if ($errors->has('name'))
                    is-invalid
                @endif">
                @if ($errors->has('name'))
                <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="deadline">DeadLine</label>
                <input value="{{ $task->deadline }}" class="form-control @if ($errors->has('deadline'))
                    is-invalid
                @endif" type="datetime-local" name="deadline" id="deadline">
                @if ($errors->has('deadline'))
                <span class="invalid-feedback">{{ $errors->first('deadline') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="user">select user</label>
                <select class=" form-control form-select form-select-lg" name="user_id" id="user">
                    @foreach (\App\Models\User::all() as $user )
                    @if($user->role->name !== 'admin')
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-success" type="submit">save</button>
    </form>
</div>
</x-layouts.dashboard>