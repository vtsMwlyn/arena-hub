<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, usePage } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import { Inertia } from '@inertiajs/inertia';

    // Access posts data passed as props
    const { props } = usePage();
    const errors = props.errors;
    const post = props.post;

    // Form data
    const form = ref({
        title: post.title,
        content: post.content,
    });

    // Methods
    const updatePost = () => {
        Inertia.put(route('posts.update', {post: post.id}), form.value);
    };
</script>

<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Posts</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-4">Edit Post</h2>

                    <form @submit.prevent="updatePost" class="flex flex-col items-start gap-5">
                        <input v-model="form.title" type="text" placeholder="Title" class="w-full" autofocus />
                        <span v-if="errors?.title" class="text-red-500">{{ errors.title }}</span>

                        <textarea v-model="form.content" placeholder="Content" class="w-full"></textarea>
                        <span v-if="errors?.content" class="text-red-500">{{ errors.content }}</span>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Edit Post</button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
