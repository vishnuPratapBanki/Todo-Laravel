<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="{{ url('frontend/css/style2.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>

    <header class="navbar navbar-expand-lg navbar-dark custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('todos.index') }}"><h2>Todo List</h2></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <button class="nav-link dropdown-toggle custom-text-color"data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-light">
                            <li><form method="POST" action = "/logout">@csrf<button class="dropdown-item">Logout</button> </form></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>

<section class="vh-10">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
          <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
            <div class="card-body py-4 px-4 px-md-5">
  
              <p class="h1 text-center mt-3 mb-4 pb-3" >
                <i class="fas fa-check-square me-1"></i>
                <u>My Todo-s</u>
              </p>
              @if (session('success'))
              <div class="d-flex justify-content-center">
                <div class="alert alert-success text-center w-50">{{ session('success') }}</div>
              </div>
              @endif

                <form action="{{ route('todos.store') }}" method="POST" class="d-flex flex-wrap justify-content-center align-items-center">
                  @csrf
                  <div class="form-group mb-3 mx-2">
                      <label for="title"><h5>New Task</h5></label>
                  </div>
                  <div class="form-group mb-3 w-50 mx-1">
                    <input type="text" name="title" class="form-control" placeholder="Task Title" required>
                  </div>
                  <div class="form-group mb-3 mx-2" >
                      <label for="due_date"><h5>Due date</h5></label>
                  </div>
                  <div class="form-group mb-3 w-5 mx-1">
                    <input type="date" name="due_date" class="form-control" min="{{ date('Y-m-d') }}">
                  </div>

                  <div class="form-group mb-3 w-5 mx-1">
                      <button type="submit" class=" btn mb-1 mx-3 custom custom-text-color">Add</button>
                  </div>
                </form>
                  
  
              <hr class="my-4">
  
                <div class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-3">
                  <form action="{{ route('todos.filter') }}" method="GET" class="d-flex">
                    @csrf
                      <p class="extra large mx-2 my-2">Filter</p>
                      <select class="select" name="filter">
                          @foreach ($filterOptions as $value => $option)
                              <option value="{{ $value }}" @if ($filter == $value) selected @endif>{{ $option }}</option>
                          @endforeach
                      </select>
                      <p class="extra large mx-2 my-2">Sort</p>
                      <select class="select" name="sort">
                          @foreach ($sortOptions as $value => $option)
                              <option value="{{ $value }}" @if ($sort == $value) selected @endif>{{ $option }}</option>
                          @endforeach
                      </select>
                      {{-- <a href="#!" style="color: #97969A;" data-mdb-toggle="tooltip" title="Ascending"><i class="fas fa-sort-amount-down-alt ms-2 mt-3 mx-2"></i></a> --}}
                      <a href="#!" style="color: #97969A;" data-mdb-toggle="tooltip" title="Ascending">
                        <i id="sortIcon" class="fas fa-sort-amount-down-alt ms-2 mt-3 mx-2"></i>
                      </a>
                      <button type="submit" class="btn btn-primary ms-2">Apply</button>
                  </form>
              </div>
<!-- Display your todos here using $todos -->

              @if ($todos->count() > 0)
                <ul class="list-group">
                    @foreach ($todos as $todo)

                        <ul class="list-group list-group-horizontal rounded-0">
                            <li class="list-group-item d-flex align-items-center ps-0 pe-3 py-1 rounded-0 border-0 bg-transparent">
                              <div class="form-check">
                                <form action="{{ route('todos.toggle', $todo->id) }}" method="POST">
                                  @csrf
                                  @method('PUT') <!-- Use PUT method in the form -->
                                  <input type="hidden" name="_method" value="PUT"> <!-- Update the hidden field to PUT -->
                                  <input class="form-check-input me-0" type="checkbox" value="1" id="completed"
                                    aria-label="..." name="completed" onchange="this.form.submit()" @if ($todo->completed) checked @endif>
                                </form>
                              </div>
                            </li>
                            <li
                              class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 border-0 bg-transparent">
                              <p class="lead fw-normal mb-0 flex-grow-1 @if ($todo->completed) completed-task @endif">{{ $todo->title }}</p>
                            </li>
                            <li class="list-group-item px-3 py-1 d-flex align-items-center border-0 bg-transparent">
                              @if ($todo->due_date)
                              <div
                                class="py-2 px-3 me-2 border border-warning rounded-3 d-flex align-items-center bg-light">
                                <p class="small mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Due Date">
                                    <i class="fas fa-hourglass-half me-2 text-warning"></i> 
                                    {{ date('d-m-Y', strtotime($todo->due_date)) }}
                                </p>
                              </div>
                              @endif
                            </li>

                            <li class="list-group-item px-3 py-1 d-flex align-items-center border-0 bg-transparent">
                                <div class="py-2 px-3 me-2 border border-warning rounded-3 d-flex align-items-center bg-light">
                                    <p class="small mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Created at"><i class="fas fa-info-circle me-2"></i>{{$todo->updated_at->format('d-m-Y') }}</p>
                                </div>
                            </li>

                            <li class="list-group-item ps-3 pe-0 py-1 rounded-0 border-0 bg-transparent">
                              <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-primary btn-sm mx-1" data-bs-toggle="modal"
                                    data-bs-target="#editTodoModal-{{ $todo->id }}"><i class="fas fa-pencil-alt"></i></button>
                                <form action="{{ route('todos.destroy', $todo) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1"><i class="fas fa-trash-alt"></i></button>
                                </form>
                              </div>
                            </li>
                        </ul>

                        <!-- Edit Todo Modal -->
                        <div class="modal fade" id="editTodoModal-{{ $todo->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="editTodoModalLabel-{{ $todo->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editTodoModalLabel-{{ $todo->id }}">Edit Todo</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>


                                    <form action="{{ route('todos.update', $todo) }}" method="POST">
                                        <div class="modal-body">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" name="title" class="form-control"
                                                    value="{{ $todo->title }}" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="date" id="due_date" name="due_date" value="{{ $todo->due_date }}"  class="form-control" min="{{ date('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </ul>
            @else
                <p>No todos found.</p>
            @endif
  
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="custom">
        Created with <i class="fa fa-heart"></i> by
        <a target="_blank" href="https://florin-pop.com">Florin Pop</a>
        - Read how I created this and how you can join the challenge
        <a target="_blank" href="https://www.florin-pop.com/blog/2019/03/double-slider-sign-in-up-form/">here</a>.
  </footer>

</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
      var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
      );
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
</script>
  
</html>