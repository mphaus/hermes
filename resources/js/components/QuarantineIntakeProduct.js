export default function QuarantineIntakeProduct () {
    return {
        init () { 
            this.initSelect2();
        },
        initSelect2 () {
            $( this.$refs.product )
                .select2( {
                    placeholder: 'Type the name of a Product',
                    width: '100%',
                    ajax: {
                        url: route( 'products.search' ),
                        dataType: 'json',
                        delay: 500,
                        processResults ( data ) {
                            return {
                                results: data,
                            };
                        }
                    },
                    minimumInputLength: 1,
                } )
                .on( 'change.select2', () => this.$wire.$parent.form.product_id = $( this.$refs.product ).val() );
        },
    };
}
