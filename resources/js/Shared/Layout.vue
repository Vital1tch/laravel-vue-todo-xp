<script>
    import {Link} from '@inertiajs/vue3'

    export default {
        components: {
            Link
        }
    }
</script>

<template>
    <div>
        <ul>
            <li>
                <Link :href="route('Home')">Home</Link>
            </li>

            <li>
                <Link :href="route('About')">About</Link>
            </li>

            <li>
                    <Link :href="route('users.index')">Users</Link>
            </li>
        </ul>

        <slot />
    </div>
</template>



