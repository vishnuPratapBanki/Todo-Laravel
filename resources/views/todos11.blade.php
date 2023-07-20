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
    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('todos.index') }}">Todo List</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <button class="nav-link dropdown-toggle"data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>

                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><form method="POST" action = "/logout">@csrf<button class="dropdown-item">Logout</button> </form></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main class="py-4">
        <div class="container">
            <h1>Todos</h1>

            <!-- Display success message if any -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Create Todo Form -->
            {{-- <form action="{{ route('todos.store') }}" method="POST" class="mt-4">
                @csrf
                <div class="form-group">
                    <input type="text" name="title" class="form-control" placeholder="Enter a new todo..." required>
                </div>
                <button type="submit" class="btn btn-primary">Add Todo</button>
            </form> --}}

            <div class="pb-2">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row align-items-center">
                        <form action="{{ route('todos.store') }}" method="POST" class="mt-4">
                            @csrf
                      <input type="text" name="title" class="form-control form-control-lg" placeholder="Add new task" required>
                      <input type="date" placeholder="Select the due date" id="due_date" name="due_date" class="form-control" min="{{ date('Y-m-d') }}" required>
                      
                        <button type="submit" class="btn btn-primary">Add</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              {{-- <div class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-3">
                <p class="small mb-0 me-2 text-muted">Filter</p>
                <select class="select">
                  <option value="1">All</option>
                  <option value="2">Completed</option>
                  <option value="3">Active</option>
                  <option value="4">Has due date</option>
                </select>
                <p class="small mb-0 ms-4 me-2 text-muted">Sort</p>
                <select class="select">
                  <option value="1">Added date</option>
                  <option value="2">Due date</option>
                </select>
                <a href="#!" style="color: #23af89;" data-mdb-toggle="tooltip" title="Ascending"><i
                    class="fas fa-sort-amount-down-alt ms-2"></i></a>
              </div> --}}

              
    

            <!-- Todo list -->
            @if ($todos->count() > 0)
                <ul class="list-group">
                    @foreach ($todos as $todo)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $todo->title }}
                            {{ $todo->due_date}}
                            <div class=" d-flex">
                                <!-- Edit Todo Button -->
                                <button type="button" class="btn btn-primary btn-sm mr-2" data-bs-toggle="modal"
                                    data-bs-target="#editTodoModal-{{ $todo->id }}">Edit</button>
                                

                                <!-- Delete Todo Form -->
                                <form action="{{ route('todos.destroy', $todo) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </li>

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
                                            @method('PUT')
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
    </main>

    <footer class="bg-light py-4 mt-4">
        <div class="container">
            <p class="text-center mb-0">&copy; {{ date('Y') }} Todo List</p>
        </div>
    </footer>

    <script src="{{ url('frontend/js/app2.js') }}"></script>
</body>

</html>