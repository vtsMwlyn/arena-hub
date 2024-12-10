<script setup>
    import AnchorButton from '@/Components/AnchorButton.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { Inertia } from '@inertiajs/inertia';

    const goToCourtWithSearch = (keyw) => {
        // Use Inertia to navigate with query parameters
        Inertia.get(route('courts.index'), { category: keyw }, {
            preserveState: true, // Optionally, preserve the state
        });
    };

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Page hero -->
                <div class="w-full flex items-end justify-center gap-5">
                    <div class="w-1/2 flex flex-col items-start">
                        <h1 class="text-3xl font-semibold"><span class="text-cyan-500">Find</span> &amp; <span class="text-cyan-500">Book</span> Your Favorite Arena!</h1>
                        <p class="tracking-widest mt-4">At <strong><span class="text-cyan-500">Arena</span>Hub</strong>, booking your next game or practice session is just a click away. Our platform offers a variety of sports facilities that you can browse and book with ease. Whether it's for a friendly match, a team practice, or an event, ArenaHub ensures you have access to the best spaces available. Fast, simple, and reliable - your next game is waiting!</p>
                        <AnchorButton :href="route('courts.index')" class="mt-4 bg-cyan-500 px-8 py-3 rounded-lg text-white" style="font-size: 20px;">Explore Now</AnchorButton>
                    </div>
                    <img src="/img/dashboard-img.jpg" class="w-1/3" alt="dashboard-img">
                </div>

                <!-- Category Selection -->
                <div class="w-full flex flex-wrap mt-28 gap-y-12">
                    <button @click="goToCourtWithSearch('Football')" class="flex flex-col items-center hover:border-2 hover:border-cyan-500 hover:rounded-xl w-1/4 justify-between">
                        <img src="img/football.jpg" class="grow" alt="football">
                        <h2 class="font-semibold text-lg">Football</h2>
                    </button>
                    <button @click="goToCourtWithSearch('Basketball')" class="flex flex-col items-center hover:border-2 hover:border-cyan-500 hover:rounded-xl w-1/4 justify-between">
                        <img src="img/basketball.jpg" class="grow" alt="basketball">
                        <h2 class="font-semibold text-lg">Basketball</h2>
                    </button>
                    <button @click="goToCourtWithSearch('Badminton')" class="flex flex-col items-center hover:border-2 hover:border-cyan-500 hover:rounded-xl w-1/4 justify-between">
                        <img src="img/badminton.jpg" class="grow" alt="badminton">
                        <h2 class="font-semibold text-lg">Badminton</h2>
                    </button>
                    <button @click="goToCourtWithSearch('Gymnastics')" class="flex flex-col items-center hover:border-2 hover:border-cyan-500 hover:rounded-xl w-1/4 justify-between">
                        <img src="img/gymnastics.jpg" class="grow" alt="gymnastics">
                        <h2 class="font-semibold text-lg">Gymnastics</h2>
                    </button>
                    <button @click="goToCourtWithSearch('Volleyball')" class="flex flex-col items-center hover:border-2 hover:border-cyan-500 hover:rounded-xl w-1/4 justify-between">
                        <img src="img/volleyball.jpg" class="grow" alt="volleyball">
                        <h2 class="font-semibold text-lg">Volleyball</h2>
                    </button>
                    <button @click="goToCourtWithSearch('Tennis')" class="flex flex-col items-center hover:border-2 hover:border-cyan-500 hover:rounded-xl w-1/4 justify-between">
                        <img src="img/tennis.jpg" class="grow" alt="tennis">
                        <h2 class="font-semibold text-lg">Tennis</h2>
                    </button>
                    <button @click="goToCourtWithSearch('Swimming')" class="flex flex-col items-center hover:border-2 hover:border-cyan-500 hover:rounded-xl w-1/4 justify-between">
                        <img src="img/swimming.jpg" class="grow" alt="swimming">
                        <h2 class="font-semibold text-lg">Swimming</h2>
                    </button>
                    <div class="flex flex-col items-center w-1/4 justify-between">
                        <div class="grow flex items-center justify-center w-full">
                            <div class="border-8 border-cyan-500 px-4 py-2 text-center font-black text-cyan-500 text-3xl">COMING<br>SOON</div>
                        </div>
                        <h2 class="font-semibold text-lg">ETC.</h2>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
