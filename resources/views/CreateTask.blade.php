<x-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">New Task</h2>

            <form action="{{route('task.store')}}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="task" class="block text-gray-700 text-sm font-semibold mb-2">Task Name:</label>
                    <input
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
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded-lg shadow leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                        <option value="">Select Priority</option>
                        <option value="urgent">Urgent</option>
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                    @error('priority')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <p class="text-center">Below write the deliverables</p>
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
                        Add Task
                    </button>
                </div>


            </form>

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