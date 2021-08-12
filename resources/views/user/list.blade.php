@extends('adminlte::page')

@section('content')
<div class="card mt-3 p-5">
    <div class="card-header">
        <h2>{{__('adminlte::menu.' . $route)}}</h2>
        <hr>
        <form action="{{ route('user.'.$route.'.post') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="name" class="sr-only">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
            </div>
            <div class="form-group mb-3">
                <label for="last_name" class="sr-only">Language</label>
                <select class="form-control" name="language" id="lang" required>
                    <option value="">select</option>
                    <option value="1">fa</option>
                    <option value="0">en</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-check"></i></button>
        </form>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('adminlte::adminlte.full_name')}}</th>
                    <th scope="col">{{__('adminlte::menu.language')}}</th>
                    <th scope="col">{{__('adminlte::menu.settings')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <th scope="row">{{$item->id}}</th>
                    <td id="name-{{$item->id}}">{{$item->name}}</td>
                    <td id="lang-{{$item->id}}">{{__('adminlte::menu.' . $item->language)}}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#listEdit"
                            data-id="{{$item->id}}">
                            <i class="fa fas fa-edit"></i>
                        </button>
                        <a href="{{ route('user.delete', ['id'=>$item->id , 'table' => $route]) }}"
                            class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="listEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.'.$route.'.edit') }}" class="form-inline" method="POST">
                    @csrf
                    <input name="id" type="number" id="id" hidden>
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name" class="sr-only">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="last_name" class="sr-only">Language</label>
                        <select id="lang" class="form-control" name="language" id="lang" required>
                            <option value="">select</option>
                            <option value="1">fa</option>
                            <option value="0">en</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-check"></i></button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $('#listEdit').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  var name = document.querySelector("#name-" + id).innerHTML;
  var lang = document.querySelector("#lang-" + id).innerHTML;
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-body #id').val(id)
  modal.find('.modal-body #name').val(name)
  modal.find('.modal-body #lang').val(lang)
})
</script>
@endsection
