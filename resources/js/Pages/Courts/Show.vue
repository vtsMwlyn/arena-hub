<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import TextInput from '@/Components/TextInput.vue';
    import AnchorButton from '@/Components/AnchorButton.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';

    import { Head, usePage } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import { Inertia } from '@inertiajs/inertia';

    // Access posts data passed as props
    const { props } = usePage();
    const court = props.court;
    const bookings = props.bookings;

    const filters = ref({
        search: '',
    });

    // Methods
    const getOperationalDays = (operationalDays) => {
        const daysArray = JSON.parse(operationalDays);
        return {
            firstDay: daysArray[0],
            lastDay: daysArray[daysArray.length - 1],
        };
    };

    const submitSearch = () => {
        Inertia.get(route('courts.show', { court: court.id }), filters.value, {
            preserveState: true, // Preserve state between requests
        });
    }

    let optionsCategories = [];
    const categories = JSON.parse(court.categories);

    for (const index in categories) {
        const ctg = categories[index];
        optionsCategories.push({ id: index, label: ctg, value: ctg });
    }

    const changePage = (url) => {
        if (url) {
            // Fetch the new page data using Inertia
            Inertia.get(url, {}, { preserveState: true });
        }
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

                    <div class="flex w-full justify-between items-center">
                        <h4 class="font-semibold mt-6 mb-2">All Bookings in This Court</h4>
                        <form @submit.prevent="submitSearch" class="flex items-center gap-x-3">
                            <TextInput
                                v-model="filters.search"
                                type="search"
                                placeholder="Search sport category..."
                            />
                            <PrimaryButton type="submit">Search</PrimaryButton>
                        </form>
                    </div>

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
                            <tr v-for="(booking, index) in bookings.data" :key="booking.id">
                                <td class="border border-slate-400 px-4 py-2">{{ index + 1 }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.date }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.start_time.substring(0, 5) }} - {{ booking.end_time.substring(0, 5) }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.booker.name }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.people }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ booking.category }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
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
