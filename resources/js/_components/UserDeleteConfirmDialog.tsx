import { SharedData, User } from "@/types";
import { usePage } from "@inertiajs/react";
import { useEffect, useRef } from "react";

export default function UserDeleteConfirmDialog({ open, user, onCancel, onOk }: {
    open: boolean;
    user?: User;
    onCancel?: () => void;
    onOk?: (user?: User) => void;
}) {
    const { name } = usePage<SharedData>().props;
    const dialogRef = useRef<HTMLDialogElement>(null);

    useEffect(() => {
        if (open) {
            dialogRef.current?.showModal();
        } else {
            dialogRef.current?.close();
        }
    }, [open]);

    return (
        <dialog
            id="user-delete-confirm-dialog"
            className="modal modal-bottom md:modal-middle"
            ref={dialogRef}
        >
            <div className="modal-box">
                <h3 className="font-bold text-lg">{name}</h3>
                <p className="py-4">
                    {'Are you sure you want to delete user '}
                    <span className="font-semibold">{`${user?.first_name ?? ''} ${user?.last_name ?? ''}`}</span>
                    {'?'}
                </p>
                <div className="modal-action">
                    <form method="dialog" className="flex items-center justify-end gap-2">
                        <button
                            type="button"
                            className="btn btn-primary"
                            onClick={onCancel}
                        >
                            {'Cancel'}
                        </button>
                        <button
                            type="button"
                            className="btn btn-error btn-soft"
                            onClick={() => onOk?.(user)}
                        >
                            {'Ok'}
                        </button>
                    </form>
                </div>
            </div>
        </dialog>
    );
}
