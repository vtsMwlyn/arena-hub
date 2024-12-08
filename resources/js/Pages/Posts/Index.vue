<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, usePage } from '@inertiajs/vue3';
    import { Inertia } from '@inertiajs/inertia';

    // Access posts data passed as props
    const { props } = usePage();
    const posts = props.posts;

    // Methods
    const deletePost = (id) => {
        if (confirm('Are you sure you want to delete this post?')) {
            Inertia.delete(route('posts.destroy', { post: id }));
        }
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
                    <h2 class="text-xl font-bold mb-6">My Posts</h2>
                    <a :href="route('posts.create')" class="bg-blue-500 text-white px-4 py-2 rounded-lg">New Post</a>

                    <table class="w-full mt-6">
                        <thead>
                            <th class="text-start border border-slate-400 px-4 py-2">#</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Title</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Content</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Actions</th>
                        </thead>

                        <tbody>
                            <tr v-for="(post, index) in posts" :key="post.id">
                                <td class="border border-slate-400 px-4 py-2">{{ index + 1 }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ post.title }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ post.content }}</td>
                                <td class="border border-slate-400 px-4 py-2">
                                    <div class="flex w-full gap-3">
                                        <a :href="route('posts.edit', { post: post.id })" class="bg-yellow-500 text-black px-4 py-2 rounded-lg">Edit</a>
                                        <button @click="deletePost(post.id)" class="bg-red-600 text-white px-4 py-2 rounded-lg">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
