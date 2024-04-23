export default function ItemsCreateForm () {
    const beforeUnloadHandler = ( e ) => {
        e.preventDefault();
        e.returnValue = true;
    };

    return {
        submitting: false,
        init () {
            this.$watch( 'submitting', isSubmitting => {
                if ( isSubmitting ) {
                    window.addEventListener( 'beforeunload', beforeUnloadHandler );
                } else {
                    window.removeEventListener( 'beforeunload', beforeUnloadHandler );
                }
            } );
        },
        destroy () {
            this.submitting = false;
        },
    };
}
