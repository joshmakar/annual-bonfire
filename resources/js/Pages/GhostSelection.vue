<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{
    rsvp: { id: number, status?: string, invitee_code: string, ghost_id?: number };
    availableGhosts: { id: number, card_front: string, card_back: string }[];
}>();

const selectedGhost = ref<number | null>(null);


</script>

<template>
    <Head title="Ocularis Infernum" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full px-6">

                <main class="mt-6">
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                        <div class="rounded-lg shadow-lg lg:col-span-2">
                            <div class="p-6 text-center">
                                <h2 class="text-lg font-semibold text-white">Pick a Card</h2>
                                
                            </div>
                        </div>
                    </div>

                    <!-- RSVP input select with options Yes, No, Maybe -->
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                        <div class="rounded-lg shadow-lg lg:col-span-2">
                            <div class="p-6 text-center">
                                <form id="ghost-select-form" :action="`/ocularis-infernum/${rsvp.id}/ghost-selection`" method="POST">
                                    <input type="hidden" name="_token" :value="$page.props.csrf_token">
                                    <input type="hidden" name="ghost_id" :value="selectedGhost">
                                </form>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                                    <template v-for="ghost in availableGhosts">
                                        <div class="relative flex flex-col items-center justify-center p-4 rounded-lg shadow-lg">
                                            <button @click="selectedGhost = ghost.id" class="mt-4 text-lg text-gray-400 underline">
                                                <img :src="`/images/${ghost.card_front}`" class="" />
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add button to go back to rsvp page -->
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                        <div class="rounded-lg shadow-lg lg:col-span-2">
                            <div class="p-6 text-center">
                                <!-- <a :href="`/ocularis-infernum/${rsvp.invitee_code}/resend`" class="text-lg mt-4 text-gray-400 underline">Resend Your Fate</a> -->
                                <form :action="`/ocularis-infernum/${rsvp.id}/resend`" method="POST">
                                    <input type="hidden" name="_token" :value="$page.props.csrf_token">
                                    <button type="submit" class="text-lg mt-4 text-gray-400 underline">Resend Your Fate</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- If ghost select, display full screen div showing back of card and confirm button -->
    <div v-if="selectedGhost" class="fixed inset-0 z-50 h-50 flex justify-center bg-black bg-opacity-100">
        <div class="relative w-96 h-96 bg-black mt-4">
            <div class="text-center">
                <img :src="`/images/${availableGhosts.find(ghost => ghost.id === selectedGhost)?.card_back}`" class="" />
                <button @click="selectedGhost = null" type="button" class="mt-4 text-lg text-gray-400 underline">Rebuke</button>
                <span class="text-lg text-gray-400 px-4">Ʊ</span>
                <button type="submit" form="ghost-select-form" class="mt-4 text-lg text-gray-400 underline">Attune</button>
            </div>
        </div>
    </div>
</template>
