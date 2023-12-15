<script setup>
import { router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
const props = defineProps({
    data: Object,
    errors: Object,
});

const form = useForm({
    title: null,
    directors: null,
    genre: null,
    agerate: "",
    duration: null,
    year: null,
});

const form_edit = useForm({
    title: props.data.title,
    directors: props.data.directors,
    genre: props.data.genre,
    agerate: props.data.agerate,
    duration: props.data.duration,
    year: props.data.year,
});

const form_delete = useForm({
    id: null,
});

const showAddModal = ref(false);

function openAddModal() {
    showAddModal.value = true;
}

function closeAddModal() {
    showAddModal.value = false;
    form.reset();
}

const showEditModal = ref(false);

function openEditModal(item) {
    form_edit.id = item.id;
    form_edit.title = item.title;
    form_edit.directors = item.directors;
    form_edit.genre = item.genre;
    form_edit.agerate = item.agerate;
    form_edit.duration = item.duration;
    form_edit.year = item.year;

    showEditModal.value = true;
}

function closeEditModal() {
    showEditModal.value = false;
    form_edit.reset();
}

async function submitAddForm() {
    try {
        router.post("/store", form);
        showAddModal.value = false;
        form.reset();
    } catch (error) {
        console.error("Error:", error);
    }
}

async function submitEditForm(id) {
    try {
        router.put("/update/" + id, form_edit);
        showEditModal.value = false;
        form_edit.reset();
    } catch (error) {
        console.error("Error:", error);
    }
}

const showDeleteModal = ref(false);

function openDeleteModal(id) {
    form_delete.id = id;
    showDeleteModal.value = true;
}

function closeDeleteModal() {
    showDeleteModal.value = false;
}
function destroy(id) {
    router.delete("/" + id);
    showDeleteModal.value = false;
}
</script>

<template>
    <div class="flex flex-col mx-20">
        <!-- Tambah Modal -->
        <div v-if="showAddModal" class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen">
                <div
                    class="absolute inset-0 bg-black opacity-25 backdrop-blur-lg"
                ></div>
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t"
                        >
                            <h3 class="text-lg font-semibold text-gray-900">
                                Add New Movie
                            </h3>
                            <button
                                type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                @click="closeAddModal"
                            >
                                <svg
                                    class="w-3 h-3"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 14 14"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                    />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form
                            class="p-4 md:p-5"
                            @submit.prevent="submitAddForm"
                        >
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label
                                        for="title"
                                        class="block mb-2 text-sm font-medium text-gray-900"
                                        >Title</label
                                    >
                                    <input
                                        v-model="form.title"
                                        type="text"
                                        name="title"
                                        id="title"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        placeholder="Movie's Title..."
                                        required=""
                                    />
                                    <div
                                        class="text-red-500 text-xs"
                                        v-if="errors.title"
                                    >
                                        {{ errors.title }}
                                    </div>
                                </div>
                                <div class="col-span-2">
                                    <label
                                        for="directors"
                                        class="block mb-2 text-sm font-medium text-gray-900"
                                        >Directors</label
                                    >
                                    <input
                                        v-model="form.directors"
                                        type="text"
                                        name="directors"
                                        id="directors"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        placeholder="Movie's Directors..."
                                        required=""
                                    />
                                    <div
                                        class="text-red-500 text-xs"
                                        v-if="errors.directors"
                                    >
                                        {{ errors.directors }}
                                    </div>
                                </div>
                                <div class="col-span-2">
                                    <label
                                        for="genre"
                                        class="block mb-2 text-sm font-medium text-gray-900"
                                        >Genre</label
                                    >
                                    <input
                                        v-model="form.genre"
                                        type="text"
                                        name="genre"
                                        id="genre"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        placeholder="Movie's Genre..."
                                        required=""
                                    />
                                    <div
                                        class="text-red-500 text-xs"
                                        v-if="errors.genre"
                                    >
                                        {{ errors.genre }}
                                    </div>
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label
                                        for="duration"
                                        class="block mb-2 text-sm font-medium text-gray-900"
                                        >Duration (Minutes)</label
                                    >
                                    <input
                                        v-model="form.duration"
                                        type="number"
                                        name="duration"
                                        id="duration"
                                        class="[&::-webkit-inner-spin-button]:appearance-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        placeholder="Movie's Duration..."
                                        min="0"
                                        oninput="this.value = Math.abs(this.value)"
                                        required
                                    />
                                    <div
                                        class="text-red-500 text-xs"
                                        v-if="errors.duration"
                                    >
                                        {{ errors.duration }}
                                    </div>
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label
                                        for="year"
                                        class="block mb-2 text-sm font-medium text-gray-900"
                                        >Year</label
                                    >
                                    <input
                                        v-model="form.year"
                                        type="number"
                                        name="year"
                                        id="year"
                                        class="[&::-webkit-inner-spin-button]:appearance-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        placeholder="Movie's Year..."
                                        required
                                        min="0"
                                        oninput="this.value = Math.abs(this.value)"
                                    />
                                    <div
                                        class="text-red-500 text-xs"
                                        v-if="errors.year"
                                    >
                                        {{ errors.year }}
                                    </div>
                                </div>
                                <div class="col-span-2">
                                    <label
                                        for="agerate"
                                        class="block mb-2 text-sm font-medium text-gray-900"
                                        >Age Rate</label
                                    >
                                    <select
                                        v-model="form.agerate"
                                        id="agerate"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                    >
                                        <option selected value="" hidden>
                                            Select Age Rate Category
                                        </option>
                                        <option value="All Ages (G)">
                                            All Ages (G)
                                        </option>
                                        <option value="PG">PG</option>
                                        <option value="PG-13">PG-13</option>
                                        <option value="R">R</option>
                                        <option value="NC-17">NC-17</option>
                                    </select>
                                    <div
                                        class="text-red-500 text-xs"
                                        v-if="errors.agerate"
                                    >
                                        {{ errors.agerate }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="text-white inline-flex items-center bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                >
                                    <svg
                                        class="me-1 -ms-1 w-5 h-5"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                    Add Movie
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showEditModal" class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen">
                <div
                    class="absolute inset-0 bg-black opacity-25 backdrop-blur-lg"
                ></div>
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t"
                        >
                            <h3 class="text-lg font-semibold text-gray-900">
                                Edit Movie
                            </h3>
                            <button
                                type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                @click="closeEditModal"
                            >
                                <svg
                                    class="w-3 h-3"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 14 14"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                    />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form
                            class="p-4 md:p-5"
                            @submit.prevent="submitEditForm(form_edit.id)"
                        >
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label
                                        for="title"
                                        class="block mb-2 text-sm font-medium text-gray-900"
                                        >Title</label
                                    >
                                    <input
                                        v-model="form_edit.title"
                                        type="text"
                                        name="title"
                                        id="title"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        required=""
                                    />
                                    <div
                                        class="text-red-500 text-xs"
                                        v-if="errors.title"
                                    >
                                        {{ errors.title }}
                                    </div>
                                </div>
                                <div class="col-span-2">
                                    <label
                                        for="directors"
                                        class="block mb-2 text-sm font-medium text-gray-900"
                                        >Directors</label
                                    >
                                    <input
                                        v-model="form_edit.directors"
                                        type="text"
                                        name="directors"
                                        id="directors"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        required=""
                                    />
                                    <div
                                        class="text-red-500 text-xs"
                                        v-if="errors.directors"
                                    >
                                        {{ errors.directors }}
                                    </div>
                                </div>
                                <div class="col-span-2">
                                    <label
                                        for="genre"
                                        class="block mb-2 text-sm font-medium text-gray-900"
                                        >Genre</label
                                    >
                                    <input
                                        v-model="form_edit.genre"
                                        type="text"
                                        name="genre"
                                        id="genre"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        required=""
                                    />
                                    <div
                                        class="text-red-500 text-xs"
                                        v-if="errors.genre"
                                    >
                                        {{ errors.genre }}
                                    </div>
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label
                                        for="duration"
                                        class="block mb-2 text-sm font-medium text-gray-900"
                                        >Duration (Minutes)</label
                                    >
                                    <input
                                        v-model="form_edit.duration"
                                        type="number"
                                        name="duration"
                                        id="duration"
                                        class="[&::-webkit-inner-spin-button]:appearance-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        placeholder="Movie's Duration..."
                                        min="0"
                                        oninput="this.value = Math.abs(this.value)"
                                        required
                                    />
                                    <div
                                        class="text-red-500 text-xs"
                                        v-if="errors.duration"
                                    >
                                        {{ errors.duration }}
                                    </div>
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label
                                        for="year"
                                        class="block mb-2 text-sm font-medium text-gray-900"
                                        >Year</label
                                    >
                                    <input
                                        v-model="form_edit.year"
                                        type="number"
                                        name="year"
                                        id="year"
                                        class="[&::-webkit-inner-spin-button]:appearance-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        placeholder="Movie's Year..."
                                        required
                                        min="0"
                                        oninput="this.value = Math.abs(this.value)"
                                    />
                                    <div
                                        class="text-red-500 text-xs"
                                        v-if="errors.year"
                                    >
                                        {{ errors.year }}
                                    </div>
                                </div>
                                <div class="col-span-2">
                                    <label
                                        for="agerate"
                                        class="block mb-2 text-sm font-medium text-gray-900"
                                        >Age Rate</label
                                    >
                                    <select
                                        v-model="form_edit.agerate"
                                        id="agerate"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                    >
                                        <option selected value="" hidden>
                                            Select Age Rate Category
                                        </option>
                                        <option value="All Ages (G)">
                                            All Ages (G)
                                        </option>
                                        <option value="PG">PG</option>
                                        <option value="PG-13">PG-13</option>
                                        <option value="R">R</option>
                                        <option value="NC-17">NC-17</option>
                                    </select>
                                    <div
                                        class="text-red-500 text-xs"
                                        v-if="errors.agerate"
                                    >
                                        {{ errors.agerate }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="text-white inline-flex items-center bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                >
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showDeleteModal" class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen">
                <div
                    class="absolute inset-0 bg-black opacity-25 backdrop-blur-lg"
                ></div>
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow">
                        <button
                            type="button"
                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            @click="closeDeleteModal"
                        >
                            <svg
                                class="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 14"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <svg
                                class="mx-auto mb-4 text-gray-400 w-12 h-12"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                />
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500">
                                Are you sure you want to delete this data?
                            </h3>
                            <button
                                @click.prevent="destroy(form_delete.id)"
                                type="button"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2"
                            >
                                Yes, I'm sure
                            </button>
                            <button
                                @click="closeDeleteModal"
                                type="button"
                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10"
                            >
                                No, cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <div class="p-1.5 w-full inline-block align-middle">
                <div class="flex flex-row my-10">
                    <div>
                        <div class="font-bold text-3xl">
                            <h1>MOVIE LISTS</h1>
                        </div>
                        <span>
                            A list of movies including its title, directors,
                            genre, age rate, duration, and year.
                        </span>
                    </div>

                    <div
                        class="ml-auto h-10 bg-blue-500 hover:bg-blue-600 rounded-md"
                    >
                        <button
                            class="inline-flex p-2 text-center text-white"
                            @click="openAddModal"
                        >
                            <svg
                                class="me-1 -ms-1 w-5 h-5"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                            Add Movie
                        </button>
                    </div>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50"
                        >
                            <tr>
                                <th scope="col" class="px-5 py-3">No</th>
                                <th scope="col" class="px-5 py-3 max-w-prose">
                                    Title
                                </th>
                                <th scope="col" class="px-5 py-3 max-w-[200px]">
                                    Directors
                                </th>
                                <th scope="col" class="px-5 py-3 max-w-[200px]">
                                    Genre
                                </th>
                                <th scope="col" class="px-5 py-3">AgeRate</th>
                                <th scope="col" class="px-5 py-3">Duration</th>
                                <th scope="col" class="px-5 py-3">Year</th>
                                <th scope="col" class="px-5 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in data"
                                :key="item.id"
                                class="odd:bg-white even:bg-gray-50 border-b"
                            >
                                <td class="px-5 py-3">{{ index + 1 }}</td>
                                <td class="px-5 py-3 max-w-prose">
                                    {{ item.title }}
                                </td>
                                <td class="px-5 py-3 max-w-[200px]">
                                    {{ item.directors }}
                                </td>
                                <td class="px-5 py-3 max-w-[200px]">
                                    {{ item.genre }}
                                </td>
                                <td class="px-5 py-3">{{ item.agerate }}</td>
                                <td class="px-5 py-3">
                                    {{ item.formatted_duration }}
                                </td>
                                <td class="px-5 py-3">{{ item.year }}</td>
                                <td class="px-5 py-3">
                                    <button
                                        class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                                        @click="openEditModal(item)"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        class="focus:outline-none text-white bg-red-500 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                                        @click="openDeleteModal(item.id)"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
