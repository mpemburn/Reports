<template>
    <div>
        <div @click="syncWithToggl" class="text-sm sm:text-right" style="cursor: pointer;">
            <span class="fas fa-sync" :class="{
                'fa-spin': syncing
            }"></span>
            SYNC
        </div>
        <span v-if="copied" class="text-sm">
            COPIED: {{ copied }}
        </span>
        <table style="width: 100%;">
            <thead style="background-color: #e2e8f0;">
                <th class="py-2">Task ID</th>
                <th>Description</th>
                <th>Dates</th>
                <th>Total Logged</th>
                <th></th>
            </thead>
            <tbody>
            <tr v-for="entry in entries" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                <td class="py-2">{{ entry.ticket_id }}</td>
                <td>{{ entry.description }}</td>
                <td class="pr-1" style="text-align: right;">{{ entry.date_span }}</td>
                <td style="text-align: right;">{{ entry.duration }}</td>
                <td>&nbsp;
                    <span
                        @click="copyDuration(entry.duration)"
                        class="far fa-clipboard"
                        style="cursor: pointer;"
                    ></span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            entries: [],
            syncing: false,
            copied: null
        }
    },
    methods: {
        getEntries() {
            axios.get('/api/toggl')
                .then(response => {
                    console.log(response);
                    this.entries = response.data.report;
                })
                .catch(response => {
                    console.log(response);
                });
        },
        syncWithToggl() {
            this.syncing = true;
            axios.post('/api/toggl')
                .then(response => {
                    if (response.data.valid) {
                        this.getEntries();
                    }
                    this.syncing = false;
                })
                .catch(response => {
                    this.syncing = false;
                    console.log(response);
                });
        },
        copyDuration(duration) {
            navigator.clipboard.writeText(duration);

            this.copied = duration;
            setTimeout(fade => {
                this.copied = null;
            }, 2000);
        }
    },
    mounted() {
        this.syncWithToggl();
    }
}
</script>

