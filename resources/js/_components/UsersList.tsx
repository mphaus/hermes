import { User } from "@/types";
import UserListItem from "./UserListItem";

export default function UsersList({ users }: {
    users: User[];
}) {
    return (
        <div className="space-y-4">
            {/* Headings (shown on all sizes) */}
            <div className="grid grid-cols-1 lg:grid-cols-10 gap-2 px-4 lg:px-6 text-xs lg:text-sm font-semibold py-2 border-b border-base-200 bg-base-100 rounded">
                <p className="col-span-2">Name</p>
                <p className="col-span-2">Username</p>
                <p className="col-span-3">Email</p>
                <p>Is admin</p>
                <p>Is enabled</p>
                <p className="text-right">Actions</p>
            </div>
            <div className="flex flex-col space-y-2">
                {users.map(user => (
                    <UserListItem key={user.id} user={user} />
                ))}
            </div>
        </div>
    );
}
