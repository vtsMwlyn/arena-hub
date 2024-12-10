<script setup>
    import AnchorButton from '@/Components/AnchorButton.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, usePage } from '@inertiajs/vue3';
    import { Inertia } from '@inertiajs/inertia';

    // Access posts data passed as props
    const { props } = usePage();
    const courts = props.courts;
    const isAdmin = props.is_admin;

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
</script>

<template>
    <Head title="Courts" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden p-6">
                    <h2 class="text-xl font-bold mb-6">All Courts</h2>

                    <AnchorButton :href="route('courts.create')">
                        New Court
                    </AnchorButton>

                    <table class="w-full mt-6">
                        <thead>
                            <th class="text-start border border-slate-400 px-4 py-2">#</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Name</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Address</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Operational Days</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Operational Hours</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Available Sports</th>
                            <th v-if="isAdmin" class="text-start border border-slate-400 px-4 py-2">Actions</th>
                        </thead>

                        <tbody>
                            <tr v-for="(court, index) in courts" :key="court.id">
                                <td class="border border-slate-400 px-4 py-2">{{ index + 1 }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ court.name }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ court.address }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ court.open.substring(0, 5) }} - {{ court.closed.substring(0, 5) }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ getOperationalDays(court.operational_days).firstDay }} - {{ getOperationalDays(court.operational_days).lastDay }}</td>
                                <td class="border border-slate-400 px-4 py-2">
                                    <ul class="list-disc list-inside">
                                        <li v-for="(sport, index) in JSON.parse(court.categories)" :key="index">{{ sport }}</li>
                                    </ul>
                                </td>
                                <td v-if="isAdmin" class="border border-slate-400 px-4 py-2">
                                    <div class="flex w-full gap-3">
                                        <a :href="route('courts.show', { court: court.id })" class="bg-green-600 text-white px-4 py-2 rounded-lg">View</a>
                                        <a :href="route('courts.edit', { court: court.id })" class="bg-yellow-500 text-black px-4 py-2 rounded-lg">Edit</a>
                                        <button @click="deleteCourt(court.id)" class="bg-red-600 text-white px-4 py-2 rounded-lg">Delete</button>
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
