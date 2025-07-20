<script>
    function edit(data, index) {
        document.getElementById("e_deliverable").value = data
        document.getElementById("index").value = index
        document.getElementById("edit_input").style.display = "block"
        document.getElementById("new_delv").style.display = "none"
    }
</script>
<x-layout>
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <div class="flex">
            <a href="/"

                class="bg-blue-600 hover:bg-blue-700 text-sm h-fit w-fit text-nowrap  text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:scale-105">
                Home
            </a>
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center w-full">Edit Task</h2>
        </div>

        <form action="{{route('task.update',$task->id)}}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="task" class="block text-gray-700 text-sm font-semibold mb-2">Task Name:</label>
                <input
                    value="{{$task->task}}"
                    type="text"
                    name="task"
                    id="task"
                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter task name"
                    required>
                @error('name')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="priority" class="block text-gray-700 text-sm font-semibold mb-2">Priority:</label>
                <select
                    name="priority"
                    id="priority"
                    value="$task->task"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded-lg shadow leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
                    <option value="">Select Priority</option>
                    @if ($task->priority == "urgent")
                    <option value="urgent" selected>Urgent</option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                    @elseif ($task->priority == "high")
                    <option value="urgent">Urgent</option>
                    <option value="high" selected>High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                    @elseif ($task->priority == "medium")
                    <option value="urgent">Urgent</option>
                    <option value="high">High</option>
                    <option value="medium" selected>Medium</option>
                    <option value="low">Low</option>
                    @elseif ($task->priority == "low")
                    <option value="urgent">Urgent</option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low" selected>Low</option>
                    @endif
                </select>
                @error('priority')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div id="new_delv">
                <p class="text-center">Below add deliverables</p>
                <div class="mb-4 flex gap-x-1">
                    <input
                        type="text"
                        name="deliverable"
                        id="deliverable"
                        id="task"
                        class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="complete...">
                    <div id="btn_add_deliverables" class="bg-yellow-600 hover:bg-yellow-700 cursor-pointer text-white font-semibold py-2 px-3 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                        Add
                    </div>

                </div>
                <div id="list_deliverables" class="px-3"></div>
                <textarea name="deliverables" style="display: none;" id="l_deliverables" cols="30"></textarea>

            </div>

            <div class="flex items-center justify-between">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:scale-105 w-full">
                    Update Task
                </button>
            </div>


        </form>

        <div>
            <div id="edit_input" style="display: none;">
                <p class="text-center">Edit deliverables</p>
                <form action="{{route('deliverable.update',$task->id)}}" method="post">
                    @CSRF
                    <div class="mb-4 flex gap-x-1">
                        <input id="index" name="index" style="display: none;">
                        <input
                            type="text"
                            name="deliverable"
                            id="e_deliverable"
                            required
                            class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="complete...">
                        <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 cursor-pointer text-white font-semibold py-2 px-3 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                            Update
                        </button>
                    </div>


                </form>
            </div>
            <div id="list_deliverables" class="px-3">
                @if ($task->deliverables == null)
                <p>no deliverables availabe</p>
                @else

                @for ($i = 0; $i < count(explode(",",$task->deliverables)); $i++)
                    <div class="mb-4 flex gap-x-1 justify-between">
                        <p>{{ explode(",",$task->deliverables)[$i]}}</p>
                        <div class=" flex gap-x-1">
                            <div onclick=edit('{{ explode(",",$task->deliverables)[$i]}}','{{$i}}') class="bg-yellow-600 hover:bg-yellow-700 cursor-pointer h-fit text-white font-semibold py-2 px-3 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                                Edit
                            </div>
                            <form action="{{route('deliverable.destroy',$task->id)}}" class="h-fit" method="post">
                                @CSRF
                                <input type="text" name="index" value="{{$i}}" style="display: none;">
                                <button type="submit" onclick="deleteD()" id="btn_del_deliverables" class="bg-red-600 hover:bg-red-700 cursor-pointer text-white font-semibold py-2 px-3 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                                    Delete
                                </button>
                            </form>

                        </div>
                    </div>
                    @endfor
                    @endif
            </div>
            <textarea name="deliverables" style="display: none;" id="l_deliverables" cols="30"></textarea>

        </div>




    </div>
</x-layout>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        let deliverables = []
        document.getElementById("btn_add_deliverables").addEventListener("click", () => {
            let deliverable = document.getElementById("deliverable")
            document.getElementById("list_deliverables").innerHTML = ""
            if (deliverable.value.trim().length == 0) {
                return
            }
            deliverables.push(deliverable.value)
            deliverable.value = ""
            let ol = document.createElement("ol")
            deliverables.forEach((element, index) => {
                let li = document.createElement("li")
                li.textContent = "- " + element
                ol.appendChild(li)
            })
            document.getElementById("list_deliverables").append(ol)
            document.getElementById("l_deliverables").value = deliverables
        })
    })
</script>