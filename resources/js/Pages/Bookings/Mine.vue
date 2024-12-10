<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, usePage } from '@inertiajs/vue3';
    import { Inertia } from '@inertiajs/inertia';

    // Access posts data passed as props
    const { props } = usePage();
    const bookings = props.bookings;

    // Methods

</script>

<template>
    <Head title="My Bookings" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden p-6">
                    <h2 class="text-xl font-bold mb-6">My Bookings</h2>

                    <table class="w-full mt-6">
                        <thead>
                            <th class="text-start border border-slate-400 px-4 py-2">#</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Date</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Duration</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Court</th>
                            <th class="text-start border border-slate-400 px-4 py-2">People</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Sport</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Actions</th>
                        </thead>

                        <tbody>
                            <tr v-for="(booking, index) in bookings" :key="booking.id">
                                <td class="border border-slate-400 px-4 py-2">{{ index + 1 }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.date }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.start_time.substring(0, 5) }} - {{ booking.end_time.substring(0, 5) }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.court.name }}</td> 
                                <td class="border border-slate-400 px-4 py-2">{{ booking.people }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.category }}</td>
                                <td class="border border-slate-400 px-4 py-2">
                                    <div class="flex w-full gap-3">
                                        <button class="bg-red-600 text-white px-4 py-2 rounded-lg">Cancel</button>
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
