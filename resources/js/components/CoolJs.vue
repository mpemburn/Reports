<template>
    <div>
        <input @keyup="matchAll" v-model="output" type="text" style="width: 500px;">
        <ul>
            <li v-for="match in matches">{{ match.pop() }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            output: null,
            matches: []
        }
    },
    methods: {
        optionalChaining() {
            let box = {
                innerBox: {
                    foo: function () { return 'The best time to plant a tree was 20 years ago. The second best time is now.'; }
                },
                nullFunction: function() { return null; },
            };
            if (box?.innerBox?.foo){
                this.output = box.innerBox.foo();
            }
        },
        matchAll() {
            let regex = /(?:^|\s)(t[a-z0-9]\w*)/gi; // matches words starting with t, case insensitive
            this.matches = this.output.matchAll(regex);
        }
    },
    mounted() {
        this.optionalChaining();
        this.matchAll();
    }
}
</script>

