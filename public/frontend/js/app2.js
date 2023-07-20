// Todo Modal
const todoModals = document.querySelectorAll('.todo-modal');
todoModals.forEach((modal) => {
    const todoId = modal.dataset.todoId;
    const editTodoForm = modal.querySelector(`#editTodoForm-${todoId}`);
    const editTodoButton = modal.querySelector(`#editTodoButton-${todoId}`);
    const closeTodoButton = modal.querySelector(`#closeTodoButton-${todoId}`);

    editTodoButton.addEventListener('click', () => {
        modal.style.display = 'block';
    });

    closeTodoButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    editTodoForm.addEventListener('submit', (event) => {
        event.preventDefault();
        // Add your logic for editing the todo
        // You can use AJAX to send the form data to the server
        modal.style.display = 'none';
    });
});