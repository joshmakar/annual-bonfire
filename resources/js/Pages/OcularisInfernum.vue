<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    // rsvp: object;
    rsvp: { id: number, status?: string };
}>();

const rsvpSelection = ref<string>('');

rsvpSelection.value = props.rsvp.status ?? '';
</script>

<template>
    <Head title="Ocularis Infernum" />
    <div class="bg-black text-white/50">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full px-6">
                <header class="pt-6">
                    <div class="flex lg:justify-center">
                        <img src="/images/ocularis-infernum-header.png" />
                    </div>
                </header>

                <main>
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                        <div class="rounded-lg shadow-lg lg:col-span-2">
                            <div class="p-6 text-center">
                                <p class="text-lg mt-4 text-gray-400">
                                    Before you lies a faded invitation:
                                </p>

                                <!-- New paragraph with cursive fance font -->
                                <p class="text-lg mt-4 text-gray-400">
                                    <span class="font-cursive">"<strong>Join us for an exclusive private viewing of The Kritocos Collection</strong>, a treasury of artifacts with spectral origins.<br>Delve into wonders unseen before, for once the collection is resealed, it shall vanish from sight forever."</span>
                                </p>

                                <!-- Location, date, time -->
                                <p class="text-lg mt-4 text-gray-400">
                                    <strong>Location:</strong> The Kritocos Collection, 4302 Shepherd Rd, 33565<br>
                                    <strong>Date:</strong> October 26th<br>
                                    <strong>Event Time:</strong> 7:00 PM - 9:00 PM<br>
                                    <strong>Doors Open:</strong> 6:00 PM - 12:00 AM
                                </p>

                                <p class="text-lg mt-4 text-gray-400">
                                    You again feel a tugging at your very essence, urging you to make a choice...
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- RSVP input select with options Yes, No, Maybe -->
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                        <div class="rounded-lg shadow-lg lg:col-span-2">
                            <div class="p-6 text-center">
                                <form :action="`/invite/${rsvp.id}`" method="POST">
                                    <input type="hidden" name="rsvp_id" value="{{ rsvp.id }}" />
                                    <input type="hidden" name="_token" :value="$page.props.csrf_token">
                                    <h2 class="text-lg font-semibold text-white">RSVP</h2>
                                    <p class="text-lg mt-4 text-gray-400">
                                        <select name="status" v-model="rsvpSelection" class="mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm">
                                            <option value="" disabled>Choose</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                            <option value="maybe">Maybe</option>
                                        </select>
                                    </p>

                                    <template v-if="!(rsvp.status && rsvp.status === rsvpSelection)">
                                    <!-- Display a message based on their selection -->
                                    <p class="text-lg mt-4 text-gray-400">
                                        {{
                                            rsvpSelection === 'yes'
                                            ? 'Succumb and choose your destiny!'
                                            : rsvpSelection === 'no'
                                            ? 'You feel your essence deteriorating as you resist...'
                                            : rsvpSelection === 'maybe'
                                            ? 'Let your fate be decided not by you...'
                                            : 'The eye watches in anticipation...' }}
                                    </p>
                                    
                                    
                                    <button :disabled="!rsvpSelection" type="submit" class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg px-4 py-2">
                                        {{
                                            rsvpSelection === 'yes'
                                            ? 'Succumb'
                                            : rsvpSelection === 'no'
                                            ? 'Resist'
                                            : rsvpSelection === 'maybe'
                                            ? 'Seal'
                                            : 'T̶̨̛̬̝̫̉͂̓̎̃̌̈́̓̍͛͂͋̾̚͝͝h̷̡̢͖͔̮̩͖̮͚̜̪͌̋̿́͛̍̂́̾͐̑͆̌̊̀͑͘e̸̡̝̠͍̫̲̩̿͊͛̒̉̇̌͊̌͘ ̶̛̼͈͇́̑̑͛̈́̀̈́̃́͒̓̈́̀̔͐Ę̴̢̖͉͕͎͇̹͙̩͉͚͈̰̊͜͝ỷ̵͔̿͐͋̔̍́͒̾͋̂͛̂̕e̶̱͇̼͇͙̺͕͕̮̲̖̝̺̝̯̿͒͒̎̂̊͜ͅ ̶̡̨̣̪͇͕̞͔͓͈̗̪͇̍̆̂̂̾̈̾͋̓̃̕̕A̷̧̡̠͚̠͌̒ẘ̵̜̩̠̥̞̱̠̘̃̏̈́͂͑̈͘ȧ̶͉̲̓̋̈́́͌̃̂̔̾̔̔̚̚ì̷͓̂̆̆̔̔̕t̸̨̨̨͕͍̱͚̳̯̦͔̎̋͒͂̄̐̕ͅş̵̭̟͔͖̰͔̮̪̺̟̥͎͚̘͎͒̂́̒̀̄͗͊̔͂̑͆͗̃͝ͅ'
                                        }}
                                    </button>
                                    </template>

                                    <template v-else>
                                    <p class="text-lg mt-4 text-gray-400">
                                        Your fate has been decided... but is it truly your own?
                                    </p>
                                    </template>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<style>

@import url('https://fonts.googleapis.com/css2?family=Playwrite+AU+VIC:wght@100..400&display=swap');

.font-cursive {
    font-family: 'Playwrite AU VIC', cursive;
}
</style>