<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{
    rsvp: { id: number, status?: string, invitee_code: string, ghost_id?: number, ghost: { card_front: string, card_back: string } };
}>();


</script>

<template>
    <Head title="Ocularis Infernum" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full px-6">

                <main class="mt-6">
                    
                    <div class="ghost-cards flex flex-row justify-center">
                        <div class="flex flex-col items-center">
                            <img :src="`/images/${rsvp.ghost.card_front}`" class="" />
                        </div>
                        <div class="flex flex-col items-center">
                            <img :src="`/images/${rsvp.ghost.card_back}`" class="" />
                        </div>
                    </div>

                    <!-- Add info about the event and to come dressed up and arrive early. Otherwise, resend your fate -->
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                        <div class="rounded-lg shadow-lg lg:col-span-2">
                            <div class="p-6 text-center">

                    <h1 class="text-xl m-2 text-center">Your RSVP has been recieved</h1>
                                <p class="text-lg mt-4 text-gray-400">
                                    <em>
                                        This year's bonfire will feature an engaging escape room experience where you are an active participant.<br>
                                        To enhance the atmosphere, feel free to dress as your spectral counterpart which has been left purposefully vague to allow creative freedom.<br>
                                        Be sure to arrive early to fully prepare for your haunting adventure.
                                    </em>
                                </p>

                                <p class="text-lg mt-4 text-gray-400">
                                    <strong>Location:</strong> 4302 Shepherd Rd, 33565<br>
                                    <strong>Date:</strong> October 26th<br>
                                    <strong>Event Time:</strong> 7:00 PM - 9:00 PM<br>
                                    <strong>Doors Open:</strong> 6:00 PM - 12:00 AM
                                </p>

                                <p class="text-lg mt-4 text-gray-400">
                                    <em>
                                        If you need to change your RSVP, please use the link below to resend your fate.
                                    </em>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Add button to go back to rsvp page -->
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                        <div class="rounded-lg shadow-lg lg:col-span-2">
                            <div class="p-6 text-center">
                                <!-- <a :href="`/invite/${rsvp.invitee_code}/resend`" class="text-lg mt-4 text-gray-400 underline">Resend Your Fate</a> -->
                                <form :action="`/invite/${rsvp.id}/resend`" method="POST">
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

    
</template>

<style scoped>
.ghost-cards img {
    width: 400px;
}
</style>