<script setup>
    import AnchorButton from '@/Components/AnchorButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

    import { Head, usePage } from '@inertiajs/vue3';
    import { Inertia } from '@inertiajs/inertia';
    import { ref } from 'vue';

    // Access courts data passed as props
    const { props } = usePage();
    const courts = props.courts;
    const isAdmin = props.auth.user.role == 'admin' ? true : false;

    const filters = ref({
        search: ''
    });

    // Methods
    const getOperationalDays = (operationalDays) => {
        const daysArray = JSON.parse(operationalDays);
        return {
            firstDay: daysArray[0],
            lastDay: daysArray[daysArray.length - 1],
        };
    };

    const deleteCourt = (id) => {
        if(confirm('This court and its related data will be deleted. Are you sure?')){
            Inertia.delete(route('courts.destroy', { court: id }));
        }
    }

    const submitSearch = () => {
        Inertia.get(route('courts.index'), filters.value, {
            preserveState: true, // Preserve state between requests
        });
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
                    <div class="flex w-full justify-between items-center">
                        <h2 class="text-xl font-bold mb-3">All Courts</h2>
                        <form @submit.prevent="submitSearch" class="flex items-center gap-x-3">
                            <TextInput
                                v-model="filters.search"
                                type="text"
                                placeholder="Search court..."
                            />
                            <PrimaryButton type="submit">Search</PrimaryButton>
                        </form>
                    </div>

                    <div v-if="$page.props.flash.success" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold">
                        {{ $page.props.flash.success }}
                    </div>

                    <div v-if="$page.props.flash.warning" class="bg-yellow-500 px-4 py-2 rounded-lg font-semibold">
                        {{ $page.props.flash.warning }}
                    </div>

                    <AnchorButton v-if="isAdmin" :href="route('courts.create')" class="mt-4">
                        New Court
                    </AnchorButton>

                    <table class="w-full mt-6">
                        <thead>
                            <th class="text-start border border-slate-400 px-4 py-2">#</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Name</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Address</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Operational Days</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Operational Hours</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Rent per Hour</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Available Sports</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Actions</th>
                        </thead>

                        <tbody>
                            <tr v-for="(court, index) in courts.data" :key="court.id">
                                <td class="border border-slate-400 px-4 py-2">{{ index + 1 }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ court.name }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ court.address }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ court.open.substring(0, 5) }} - {{ court.closed.substring(0, 5) }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ getOperationalDays(court.operational_days).firstDay }} - {{ getOperationalDays(court.operational_days).lastDay }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ court.rent_per_hour }}</td>
                                <td class="border border-slate-400 px-4 py-2">
                                    <ul class="list-disc list-inside">
                                        <li v-for="(sport, index) in JSON.parse(court.categories)" :key="index">{{ sport }}</li>
                                    </ul>
                                </td>
                                <td class="border border-slate-400 px-4 py-2">
                                    <div class="flex w-full gap-3">
                                        <AnchorButton :href="route('courts.show', { court: court.id })" class="bg-green-600 text-white px-4 py-2 rounded-lg">View</AnchorButton>
                                        <AnchorButton v-if="isAdmin" :href="route('courts.edit', { court: court.id })" class="bg-yellow-500 text-black px-4 py-2 rounded-lg">Edit</AnchorButton>
                                        <PrimaryButton v-if="isAdmin" @click="deleteCourt(court.id)" class="bg-red-600 text-white px-4 py-2 rounded-lg">Delete</PrimaryButton>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="pagination mt-6 flex items-center gap-x-4">
                        <PrimaryButton
                            @click="changePage(courts.prev_page_url)"
                            :disabled="!courts.prev_page_url"
                        >
                            Previous
                        </PrimaryButton>

                        <span>Page {{ courts.current_page }} of {{ courts.last_page }}</span>

                        <PrimaryButton
                            @click="changePage(courts.next_page_url)"
                            :disabled="!courts.next_page_url"
                        >
                            Next
                        </PrimaryButton>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
