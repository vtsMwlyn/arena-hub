<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { Head, useForm, usePage } from '@inertiajs/vue3';

    const { props } = usePage();
    const court = props.court;

    const form = useForm({
        date: '',
        start_time: '',
        end_time: '',
        category: '',
        people: 0,
    });

    // Methods
    let optionsCategories = [];
    const categories = JSON.parse(court.categories);

    for (const index in categories) {
        const ctg = categories[index];
        optionsCategories.push({ id: index, label: ctg, value: ctg });
    }

    const storeBooking = () => {
        form.post(route('bookings.store', { court: court.id }));
    };
</script>

<template>
    <Head title="Courts" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden p-6">
                    <h2 class="text-xl font-bold mb-6">New Booking</h2>

                    <form @submit.prevent="storeBooking">
                        <div>
                            <InputLabel for="date" value="Date" />

                            <TextInput
                                id="date"
                                type="date"
                                class="mt-1 block w-full"
                                v-model="form.date"
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.date" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="start_time" value="Start Time" />

                            <TextInput
                                id="start_time"
                                type="time"
                                class="mt-1 block w-full"
                                v-model="form.start_time"
                            />

                            <InputError class="mt-2" :message="form.errors.start_time" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="end_time" value="End Time" />

                            <TextInput
                                id="end_time"
                                type="time"
                                class="mt-1 block w-full"
                                v-model="form.end_time"
                            />

                            <InputError class="mt-2" :message="form.errors.end_time" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="category" value="Sport Category" />

                            <select v-model="form.category" id="category" class="w-full block mt-1 border p-2 border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">
                                <option v-for="sport in optionsCategories" :key="sport.id" :value="sport.value">
                                    {{ sport.label }}
                                </option>
                            </select>

                            <InputError class="mt-2" :message="form.errors.category" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="people" value="Number of People" />

                            <TextInput
                                id="people"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.people"
                            />

                            <InputError class="mt-2" :message="form.errors.people" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Book
                            </PrimaryButton>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
