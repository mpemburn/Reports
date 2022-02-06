<template>
    <div>
        <div @click="syncWithToggl" class="text-sm sm:text-right" style="cursor: pointer;">
            <span class="fas fa-sync" :class="{
                'fa-spin': syncing
            }"></span>
            SYNC
        </div>
        <table style="width: 100%;">
            <thead>
                <th>Ticket ID</th>
                <th>Description</th>
                <th>Total Logged</th>
                <th></th>
            </thead>
            <tbody>
            <tr v-for="entry in entries">
                <td>{{ entry.ticket_id }}</td>
                <td>{{ entry.description }}</td>
                <td>{{ entry.duration }}</td>
                <td><span
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
            syncing: false
        }
    },
    methods: {
        getEntries() {
            axios.get('/api/toggl')
                .then(response => {
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
            navigator.clipboard.writeText(duration);        }
    },
    mounted() {
        this.getEntries();
    }
}
</script>

