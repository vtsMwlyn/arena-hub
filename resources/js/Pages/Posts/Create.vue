<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, usePage } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import { Inertia } from '@inertiajs/inertia';

    // Retrieve errors and old input data from the page props
    const { props } = usePage();
    const errors = props.errors;

    // Initialize form data, using old input values if available
    const form = ref({
        title: '',
        content: '',
    });

    // Method to store the post
    const storePost = () => {
        Inertia.post(route('posts.store'), form.value);
    };
</script>

<template>
    <Head title="Create Post" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Post</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-4">Create Post</h2>

                    <form @submit.prevent="storePost" class="flex flex-col items-start gap-5">
                        <!-- Title input with old value and error handling -->
                        <input v-model="form.title" type="text" placeholder="Title" class="w-full" autofocus/>
                        <span v-if="errors?.title" class="text-red-500">{{ errors.title }}</span>

                        <!-- Content input with old value and error handling -->
                        <textarea v-model="form.content" placeholder="Content" class="w-full"></textarea>
                        <span v-if="errors?.content" class="text-red-500">{{ errors.content }}</span>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Create Post</button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
