<template>
    <div class="flex items-center">
        <div class="flex w-full bg-white shadow rounded">
            <input class="relative w-full px-6 py-3 rounded-r border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" autocomplete="off" type="text" name="search" :value="value" placeholder="Caută…" @input="$emit('input', $event.target.value)" />
        </div>
        <button class="ml-3 text-sm text-gray-500 hover:text-gray-700 focus:text-indigo-500 focus:outline-none" type="button" @click="$emit('reset')">Resetează</button>
    </div>
</template>

<script>
export default {
    props: ['value']
}
</script>
