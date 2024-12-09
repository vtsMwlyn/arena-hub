<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, usePage } from '@inertiajs/vue3';
    import { Inertia } from '@inertiajs/inertia';

    // Access posts data passed as props
    const { props } = usePage();
    const courts = props.courts;

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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-6">All Courts</h2>

                    <table class="w-full mt-6">
                        <thead>
                            <th class="text-start border border-slate-400 px-4 py-2">#</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Name</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Address</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Operational Days</th>
                            <th class="text-start border border-slate-400 px-4 py-2">Operational Hours</th>
                        </thead>

                        <tbody>
                            <tr v-for="(court, index) in courts" :key="court.id">
                                <td class="border border-slate-400 px-4 py-2">{{ index + 1 }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ court.name }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ court.address }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ court.open.substring(0, 5) }} - {{ court.close.substring(0, 5) }}</td>
                                <td class="border border-slate-400 px-4 py-2">{{ getOperationalDays(court.operational_days).firstDay }} - {{ getOperationalDays(court.operational_days).lastDay }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
