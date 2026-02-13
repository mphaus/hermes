export default function FormGroup({ children }: {
    children: React.ReactNode;
}) {
    return (
        <div className="[&_label]:block [&_label]:mb-2 [&_label]:font-semibold">
            {children}
        </div>
    );
}
