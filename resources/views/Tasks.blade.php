<script>
    function popup(data) {
        let popup = document.getElementById("popup")
        document.getElementById("task_title").innerHTML = data.task
        if(data.deliverables == null){
            let li = document.createElement("li")
            li.textContent = "No deliverables to complete"
            li.style.textAlign = "center"
            li.style.fontSize = "small"

            document.getElementById("deliverables_list").append(li)
            popup.style.display = "block"
            return
        }
        let delvs = data.deliverables.split(",")
        document.getElementById("deliverables_list").innerHTML = ''
        delvs.forEach(element => {
            let li = document.createElement("li")
            li.textContent = "- " + element
            document.getElementById("deliverables_list").append(li)
        })

        popup.style.display = "block"
    }

    function closePop() {
        document.getElementById("popup").style.display = "none"
    }
</script>
<x-layout>
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-3xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800" style="text-align: center;">Tasks Dashboard</h1>
            <a href="/create" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                Add Task
            </a>
        </div>

        @if(session('success'))
        <div id="session_success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if (session('error'))
        <div id="session_error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif




        @if($tasks->isEmpty())
        <p class="text-gray-600 text-center py-8">No tasks found. Click "Add Task" to create one!</p>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-50 text-left text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left rounded-tl-lg">ID</th>
                        <th class="py-3 px-6 text-left">Task</th>
                        <th class="py-3 px-6 text-left">Priority</th>
                        <th class="py-3 px-6 text-center rounded-tr-lg">Actions</th>
                    </tr>
                </thead>
                <tbody id="table_body" class=" task-list text-gray-700 text-sm font-light">
                    @foreach($tasks as $task)
                    <tr class=" task border-b border-gray-200 hover:bg-gray-100" draggable="true">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <span class="font-medium">{{ $task->id }}</span>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <p onclick="popup({{ json_encode($task) }})" class="text-blue-600 hover:underline">
                                {{ $task->task }}
                            </p>
                        </td>
                        <td class="py-3 px-6 text-left">
                            @if ($task->priority == "urgent")
                            <p class="px-3  bg-red-500/80 w-fit rounded text-white">{{ $task->priority }} </p>
                            @elseif ($task->priority == "high")
                            <p class="px-3  bg-yellow-600 w-fit rounded text-white">{{ $task->priority }} </p>
                            @elseif ($task->priority == "medium")
                            <p class="px-3  bg-green-600 w-fit rounded text-white">{{ $task->priority }} </p>
                            @elseif ($task->priority == "low")
                            <p class="px-3  bg-blue-500/70 w-fit rounded text-white">{{ $task->priority }} </p>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center space-x-2">
                                <a href="{{ route('task.edit', $task->id) }}" class="w-8 h-8 flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white rounded-full transition duration-300 ease-in-out transform hover:scale-110" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <form action="{{ route('task.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center bg-red-500 hover:bg-red-600 text-white rounded-full transition duration-300 ease-in-out transform hover:scale-110" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="popup" class=" w-screen h-screen bg-blue-600 bg-opacity-30  absolute z-10 top-0 left-0 flex justify-center align-middle items-center" style="display: none;">

                <div class="w-3/4 h-fit  bg-white mx-auto  px-10 py-10 mt-20">
                    <div class="flex justify-between  m-2 text-center">
                        <div class="flex justify-center w-full font-bold mb-3 text-3xl text-gray-800">
                            <h3 class="text-black">Task: </h3>
                            <p  id="task_title">isis</p>
                        </div>
                        <div onclick="closePop()" class="bg-blue-600 w-fit cursor-pointer mr-4 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                            close
                        </div>

                    </div>
                    <h5 class="text-center">Below are deliverables of the task</h5>
                    <ul id="deliverables_list" class=" w-3/4 mx-auto">
                    </ul>
                </div>

            </div>
        </div>
        @endif

    </div>
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            document.getElementById("session_success").style.display = "none"
            document.getElementById("session_error").style.display = "none"
        }, 5000);


        const sortableList = document.querySelector("#table_body");
        const items = sortableList.querySelectorAll(".task");

        items.forEach(item => {
            item.addEventListener("dragstart", () => {
                setTimeout(() => item.classList.add("dragging"), 0);
            });
            item.addEventListener("dragend", () => item.classList.remove("dragging"));
        });

        const initSortableList = (e) => {
            e.preventDefault();
            const draggingItem = document.querySelector(".dragging");
            let siblings = [...sortableList.querySelectorAll(".task:not(.dragging)")];
            let nextSibling = siblings.find(sibling => {
                return e.clientY <= sibling.offsetTop + sibling.offsetHeight / 0.5;
            });

            sortableList.insertBefore(draggingItem, nextSibling);
        }

        sortableList.addEventListener("dragover", initSortableList);
        sortableList.addEventListener("dragenter", e => e.preventDefault());

    })
</script>