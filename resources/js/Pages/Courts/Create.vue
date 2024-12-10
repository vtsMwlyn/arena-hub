<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { Head, useForm } from '@inertiajs/vue3';

    const form = useForm({
        name: '',
        address: '',
        open: '00:00',
        closed: '00:00',
        operational_days: [],
        categories: [],
        rent_per_hour: 0,
    });

    // Methods
    const optionsOperationalDays = [
        { id: 1, label: "Monday", value: "Monday" },
        { id: 2, label: "Tuesday", value: "Tuesday" },
        { id: 3, label: "Wednesday", value: "Wednesday" },
        { id: 4, label: "Thursday", value: "Thursday" },
        { id: 5, label: "Friday", value: "Friday" },
        { id: 6, label: "Saturday", value: "Saturday" },
        { id: 7, label: "Sunday", value: "Sunday" },
    ];

    const optionsCategories = [
        { id: 1, label: "Football", value: "Football" },
        { id: 2, label: "Basketball", value: "Basketball" },
        { id: 3, label: "Badminton", value: "Badminton" },
        { id: 4, label: "Gymnastics", value: "Gymnastics" },
        { id: 5, label: "Volleyball", value: "Volleyball" },
        { id: 6, label: "Tennis", value: "Tennis" },
        { id: 7, label: "Swimming", value: "Swimming" },
    ];

    const storeCourt = () => {
        form.post(route('courts.store'));
    };

    const showPicker = (event) => {
        try {
            if (event.target.showPicker) {
                event.target.showPicker(); // Explicitly trigger the time picker
            } else {
                event.target.click(); // Fallback for older browsers
            }
        } catch (error) {
            if (error.name !== 'NotAllowedError') {
                console.error('Unexpected error:', error);
            }
        }
    };
</script>

<template>
    <Head title="Courts" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden p-6">
                    <h2 class="text-xl font-bold mb-6">New Court</h2>

                    <form @submit.prevent="storeCourt">
                        <div>
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="address" value="Address" />

                            <TextInput
                                id="address"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.address"
                            />

                            <InputError class="mt-2" :message="form.errors.address" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="open" value="Open Hour" />

                            <TextInput
                                id="open"
                                type="time"
                                class="mt-1 block w-full"
                                v-model="form.open"
                                @click="showPicker"
                                @focus="showPicker"
                            />

                            <InputError class="mt-2" :message="form.errors.open" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="closed" value="Closed Hour" />

                            <TextInput
                                id="closed"
                                type="time"
                                class="mt-1 block w-full"
                                v-model="form.closed"
                                @click="showPicker"
                                @focus="showPicker"
                            />

                            <InputError class="mt-2" :message="form.errors.closed" />
                        </div>

                        <div class="mt-4">
                            <InputLabel value="Operational Days" />

                            <div v-for="option in optionsOperationalDays" :key="option.id" class="my-2">
                                <label>
                                    <input
                                        type="checkbox"
                                        :value="option.value"
                                        v-model="form.operational_days"
                                        class="mr-2"
                                    />
                                    {{ option.label }}
                                </label>
                            </div>

                            <InputError class="mt-2" :message="form.errors.operational_days" />
                        </div>

                        <div class="mt-4">
                            <InputLabel value="Sport Categories Available" />

                            <div v-for="option in optionsCategories" :key="option.id" class="my-2">
                                <label>
                                    <input
                                        type="checkbox"
                                        :value="option.value"
                                        v-model="form.categories"
                                        class="mr-2"
                                    />
                                    {{ option.label }}
                                </label>
                            </div>

                            <InputError class="mt-2" :message="form.errors.categories" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="rent_per_hour" value="Rent per Hour" />

                            <TextInput
                                id="rent_per_hour"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.rent_per_hour"
                            />

                            <InputError class="mt-2" :message="form.errors.rent_per_hour" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Create
                            </PrimaryButton>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
