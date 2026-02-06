import { User } from "@/types";
import UserListItem from "./UserListItem";
import UserDeleteConfirmDialog from "./UserDeleteConfirmDialog";
import { useState } from "react";

export default function UsersList({ users }: {
    users: User[];
}) {
    const [deleteConfirmDialogOpen, setDeleteConfirmDialogOpen] = useState(false);
    const [userToDelete, setUserToDelete] = useState<User | undefined>(undefined);
    const handleDeleteCancel = () => {
        setDeleteConfirmDialogOpen(false);
        setTimeout(() => setUserToDelete(undefined), 250);
    }
    const handleDeleteOk = (user?: User) => {
        setDeleteConfirmDialogOpen(false);
        setUserToDelete(user);

        if (!user) return;

        // IMPLEMENT DELETE USER LOGIC HERE
    }

    return (
        <>
            <div className="space-y-4">
                <div className="hidden md:flex card bg-base-100 card-xs">
                    <div className="card-body">
                        <div className="grid grid-cols-6 items-center text-center font-semibold">
                            <p>{'Name'}</p>
                            <p>{'Username'}</p>
                            <p>{'Email'}</p>
                            <p>{'Is admin'}</p>
                            <p>{'Is enabled'}</p>
                            <p>{'Actions'}</p>
                        </div>
                    </div>
                </div>
                <div className="space-y-2">
                    {users.map(user => (
                        <UserListItem
                            key={user.id}
                            user={user}
                            onDelete={(userToDelete) => { setDeleteConfirmDialogOpen(true); setUserToDelete(userToDelete); }}
                        />
                    ))}
                </div>
            </div>
            <UserDeleteConfirmDialog
                open={deleteConfirmDialogOpen}
                user={userToDelete}
                onCancel={handleDeleteCancel}
                onOk={(user) => handleDeleteOk(user)}
            />
        </>
    );
}
