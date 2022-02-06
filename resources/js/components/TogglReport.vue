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
            </thead>
            <tbody>
            <tr v-for="entry in entries">
                <td>{{ entry.ticket_id }}</td>
                <td>{{ entry.description }}</td>
                <td class="text-right">{{ entry.duration }}</td>
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
        }
    },
    mounted() {
        this.getEntries();
    }
}
</script>

