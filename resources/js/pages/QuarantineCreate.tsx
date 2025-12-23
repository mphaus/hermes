import QuarantineForm from "@/_components/QuarantineForm";

export default function QuarantineCreate() {
    return (
        <div className="mx-auto max-w-3xl">
            <div className="card bg-base-100">
                <div className="card-body">
                    <QuarantineForm />
                </div>
            </div>
        </div>
    );
}
