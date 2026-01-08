export default function FormError({ message }: {
    message: string;
}) {
    return (
        <p className="text-xs mt-1 text-error font-semibold">{ message }</p>
    );
}
