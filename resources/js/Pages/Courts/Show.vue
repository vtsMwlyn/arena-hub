<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import AnchorButton from '@/Components/AnchorButton.vue';
    import { Head, usePage } from '@inertiajs/vue3';

    // Access posts data passed as props
    const { props } = usePage();
    const court = props.court;
    const bookings = court.bookings;

    // Methods
    const getOperationalDays = (operationalDays) => {
        const daysArray = JSON.parse(operationalDays);
        return {
            firstDay: daysArray[0],
            lastDay: daysArray[daysArray.length - 1],
        };
    };
</script>

<template>
    <Head title="Courts" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden p-6">
                    <h2 class="text-xl font-bold mb-6">{{ court.name }}</h2>

                    <h4 class="font-semibold mb-2">Court Informations</h4>
                    <table class="w-full">
                        <tr>
                            <th class="text-start w-1/5 px-4 py-2 border border-slate-400">Address</th>
                            <td class="px-4 py-2 border border-slate-400">
                                {{ court.address }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-start w-1/5 px-4 py-2 border border-slate-400">Operational Days</th>
                            <td class="px-4 py-2 border border-slate-400">
                                {{ getOperationalDays(court.operational_days).firstDay }} - {{ getOperationalDays(court.operational_days).lastDay }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-start w-1/5 px-4 py-2 border border-slate-400">Operational Hour</th>
                            <td class="px-4 py-2 border border-slate-400">
                                {{ court.open.substring(0, 5) }} - {{ court.closed.substring(0, 5) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-start w-1/5 px-4 py-2 border border-slate-400">Available Sport Categories</th>
                            <td class="px-4 py-2 border border-slate-400">
                                <ul class="list-disc list-inside">
                                    <li v-for="(sport, index) in JSON.parse(court.categories)" :key="index">{{ sport }}</li>
                                </ul>
                            </td>
                        </tr>
                    </table>

                    <AnchorButton :href="route('bookings.create', {court: court.id})" class="mt-4">
                        New Booking
                    </AnchorButton>

                    <h4 class="font-semibold mt-6 mb-2">All Bookings in This Court</h4>
                    <table class="w-full">
                        <thead>
                            <th class="text-start border border-slate-400 px-4 py-2">#</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Date</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Duration</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Booker</th>
                            <th class="text-start border border-slate-400 px-4 py-2">People</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Sport</th>
                        </thead>

                        <tbody>
                            <tr v-for="(booking, index) in bookings" :key="booking.id">
                                <td class="border border-slate-400 px-4 py-2">{{ index + 1 }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.date }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.start_time.substring(0, 5) }} - {{ booking.end_time.substring(0, 5) }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.booker.name }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.people }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.category }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
