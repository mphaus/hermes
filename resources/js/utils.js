export function normalizeString ( ...strings ) {
    return strings
        .join( ' ' )
        .normalize( 'NFD' )
        .replace( /[\u0300-\u036f]/g, '' )
        .toLowerCase()
        .trim()
        .replace( /\s+/g, '.' )
        .replace( /[^\w\.]/g, '' );
}
