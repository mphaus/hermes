import { User } from "@/types";
import UserListItem from "./UserListItem";

export default function UsersList({ users }: {
    users: User[];
}) {
    return (
        <div className="space-y-4">
            <div className="card bg-base-100 card-xs">
                <div className="card-body">
                    <div className="grid grid-cols-6 items-center text-center font-semibold">
                        <p>Name</p>
                        <p>Username</p>
                        <p>Email</p>
                        <p>Is admin</p>
                        <p>Is enabled</p>
                        <p>Actions</p>
                    </div>
                </div>
            </div>
            <div className="space-y-2">
                {users.map(user => (
                    <UserListItem key={user.id} user={user} />
                ))}
            </div>
        </div>
    );
}
