<script setup>
import { onBeforeMount, ref, watchEffect } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

const availableChangeableTexts = [
    'The first platform to manage your autopark.',
    'Take care of your autopark.'
];
let descriptionString = ref('Whether you operate a small or a large-scale autovehicle park, our application offers powerful features to enhance efficiency, maximize revenue, and improve customer satisfaction.');
let presentationImage = ref('https://images.unsplash.com/photo-1543465077-db45d34b88a5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2012&q=80');
let randomIndexForArray = ref(0);
let changeableText = ref('');
watchEffect(() => {
    const interval = setInterval(() => {
        randomIndexForArray.value = (randomIndexForArray.value + 1) % availableChangeableTexts.length;
        changeableText.value = availableChangeableTexts[randomIndexForArray.value];
    }, 5000);

    return () => {
        clearInterval(interval);
    };
});

onBeforeMount(() => {
    randomIndexForArray.value = Math.floor(Math.random() * availableChangeableTexts.length);
    changeableText.value = availableChangeableTexts[randomIndexForArray.value];
});
</script>

<template>
    <Head title="Welcome" />

    <div class="relative bg-gray-100 dark:bg-gray-900">
        <div class="mx-auto max-w-7xl lg:grid lg:grid-cols-12 lg:gap-x-8 lg:px-8 min-h-screen">
            <div class="px-6 pb-24 pt-10 sm:pb-32 lg:col-span-7 lg:px-0 lg:pb-56 lg:pt-48 xl:col-span-6">
                <div class="mx-auto max-w-2xl lg:mx-0">
                    <div class="hidden sm:mt-32 sm:flex lg:mt-16">
                        <div class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-500 ring-gray-900/10 hover:ring-gray-900/20 dark:text-gray-200 ring-1 dark:ring-white/10 dark:hover:ring-white/20">
                            {{ changeableText }} <a href="#" class="whitespace-nowrap font-semibold dark:text-yellow-600 text-indigo-600 uppercase"><span class="absolute inset-0" aria-hidden="true" />NEW</a>
                        </div>
                    </div>
                    <h1 class="mt-24 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:mt-10 sm:text-6xl">Autopark <span class="font-semibold dark:text-yellow-600 text-indigo-600 uppercase" aria-hidden="true">Web</span></h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-400">{{ descriptionString }}</p>
                    <div class="mt-10 flex items-center gap-x-6">
                        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:left-0 p-6 text-right z-10">
                            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Dashboard</Link>

                            <template v-else>
                                <Link :href="route('login')" class="uppercase text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white p-2 outline outline-2 rounded-sm outline-indigo-600 dark:outline-yellow-600">Log in</Link>

                                <Link v-if="canRegister" :href="route('register')" class="ml-4 uppercase text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Register</Link>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative hidden lg:block lg:col-span-5 lg:-mr-8 xl:absolute xl:inset-0 xl:left-1/2 xl:mr-0">
                <img class="aspect-[3/2] w-full bg-gray-50 object-cover lg:absolute lg:inset-0 lg:aspect-auto lg:h-full" :src="presentationImage" alt="" />
            </div>
        </div>
    </div>
</template>
