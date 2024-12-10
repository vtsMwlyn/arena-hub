<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    
    import { Head, usePage } from '@inertiajs/vue3';
    import { Inertia } from '@inertiajs/inertia';

    // Access posts data passed as props
    const { props } = usePage();
    const bookings = props.bookings;

    // Methods
    const deleteBooking = (id) => {
        if(confirm('Are you sure want to cancel this booking?')){
            Inertia.delete(route('bookings.destroy', { booking: id }));
        }
    }

    function calculateSubtotal(date, startTime, endTime, rent) {
        // Convert start and end time strings to Date objects
        const start = new Date(`${date}T${startTime}`);
        const end = new Date(`${date}T${endTime}`);

        // Calculate the difference in milliseconds
        const diffInMillis = end.getTime() - start.getTime();

        // Check if the start time is earlier than the end time
        if (diffInMillis < 0) {
            return 'Invalid time range';
        }

        // Convert milliseconds to hours and round to 2 decimal places
        const diffInHours = (diffInMillis / (1000 * 60 * 60)).toFixed(2); // Rounded to 2 decimal places

        return diffInHours * rent;
    }

    const changePage = (url) => {
        if (url) {
            // Fetch the new page data using Inertia
            Inertia.get(url, {}, { preserveState: true });
        }
    };
</script>

<template>
    <Head title="My Bookings" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden p-6">
                    <h2 class="text-xl font-bold mb-3">My Bookings</h2>

                    <div v-if="$page.props.flash.success" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold">
                        {{ $page.props.flash.success }}
                    </div>

                    <div v-if="$page.props.flash.warning" class="bg-yellow-500 px-4 py-2 rounded-lg font-semibold">
                        {{ $page.props.flash.warning }}
                    </div>

                    <table class="w-full mt-6">
                        <thead>
                            <th class="text-start border border-slate-400 px-4 py-2">#</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Date</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Duration</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Court</th>
                            <th class="text-start border border-slate-400 px-4 py-2">People</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Sport</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Subtotal</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Actions</th>
                        </thead>

                        <tbody>
                            <tr v-for="(booking, index) in bookings.data" :key="booking.id">
                                <td class="border border-slate-400 px-4 py-2">{{ index + 1 }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.date }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.start_time.substring(0, 5) }} - {{ booking.end_time.substring(0, 5) }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.court.name }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.people }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.category }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ calculateSubtotal(booking.date, booking.start_time, booking.end_time, booking.court.rent_per_hour) }}</td>
                                <td class="border border-slate-400 px-4 py-2">
                                    <div class="flex w-full gap-3">
                                        <button @click="deleteBooking(booking.id)" class="bg-red-600 text-white px-4 py-2 rounded-lg">Cancel</button>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                    </table>

                    <div class="pagination mt-6 flex items-center gap-x-4">
                        <PrimaryButton
                            @click="changePage(bookings.prev_page_url)"
                            :disabled="!bookings.prev_page_url"
                        >
                            Previous
                        </PrimaryButton>

                        <span>Page {{ bookings.current_page }} of {{ bookings.last_page }}</span>

                        <PrimaryButton
                            @click="changePage(bookings.next_page_url)"
                            :disabled="!bookings.next_page_url"
                        >
                            Next
                        </PrimaryButton>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
