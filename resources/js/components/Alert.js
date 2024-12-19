export default function Alert () {
    let timeout = null;

    return {
        init () {
            timeout = setTimeout( () => {
                this.$root.remove();
            }, 5000 );
        },
        close () {
            if ( timeout ) {
                clearTimeout( timeout );
            }

            this.$root.remove();
        },
    };
}
