<template>
    Show something
</template>

<script>
export default {
    methods: {
        getHackData(email, lastLogin) {
            axios.get('https://hackcheck.woventeams.com/api/v4/breachedaccount/' + email)
                .then(response => {
                    let results = {
                        success: true,
                        meta: {
                            suggestPasswordChange: true,
                            breachedAccounts: this.parseData(response.data, lastLogin)
                        }
                    }
                    console.log(results);
                }).catch((err) => {
                    console.log(err);
                });
        },
        parseData(data, lastLogin) {
            let self = this;

            return data.filter(item => {
                return ! item.isSensitive
                    && item.DataClasses.includes('Passwords')
                    && self.isAfterDate(lastLogin, item.AddedDate);
            }).map(item => {
                return {
                    name: item.Name,
                    domain: item.Domain,
                    breachDate: item.BreachDate,
                    addedDate: item.AddedDate
                }
            });
        },
        isAfterDate(loginDate, addedDate) {
            return new Date(addedDate) > new Date(loginDate);
        }
    },
    mounted() {
        this.getHackData('test@example.com', '2016-01-01T08:51:33.912Z')
    }
}
</script>
