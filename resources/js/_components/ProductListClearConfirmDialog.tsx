import { useEffect, useRef } from "react";

export default function ProductListClearConfirmDialog({ open, onCancel, onOk }: {
    open?: boolean;
    onCancel?: () => void;
    onOk?: () => void;
}) {
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
            id="product-list-clear-confirm-dialog"
            className="modal modal-bottom md:modal-middle"
            ref={dialogRef}
        >
            <div className="modal-box">
                <p className="py-4">
                    {'Are you sure you want to clear all products?'}
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
                            onClick={onOk}
                        >
                            {'Ok'}
                        </button>
                    </form>
                </div>
            </div>
        </dialog>
    );
}