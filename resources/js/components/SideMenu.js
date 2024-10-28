export default function SideMenu () {
    return {
        open: false,
        /**
         * @param {boolean} open
         */
        sideMenuToggleEffect ( open ) {
            document.documentElement.classList.toggle( 'max-xl:overflow-hidden', open );
        }
    };
}
