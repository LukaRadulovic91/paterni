<?php

namespace paterni\Behavioral\Mediator\RealExample;

/**
 * Unlike our Observer pattern example, this example makes the UserRepository
 * act as a regular component that doesn't have any special event-related
 * methods. Like any other component, this class relies on the EventDispatcher
 * to broadcast its events and listen for the other ones.
 *
 * @see \RefactoringGuru\Observer\RealWorld\UserRepository
 */
class UserRepository implements Observer
{
    /**
     * @var array List of application's users.
     */
    private $users = [];

    /**
     * Components can subscribe to events by themselves or by client code.
     */
    public function __construct()
    {
        events()->attach($this, "users:deleted");
    }

    /**
     * Components can decide whether they'd like to process an event using its
     * name, emitter or any contextual data passed along with the event.
     */
    public function update(string $event, object $emitter, $data = null): void
    {
        switch ($event) {
            case "users:deleted":
                if ($emitter === $this) {
                    return;
                }
                $this->deleteUser($data, true);
                break;
        }
    }

    // These methods represent the business logic of the class.

    public function initialize(string $filename): void
    {
        echo "UserRepository: Loading user records from a file.\n";
        // ...
        events()->trigger("users:init", $this, $filename);
    }

    public function createUser(array $data, bool $silent = false): User
    {
        echo "UserRepository: Creating a user.\n";

        $user = new User();
        $user->update($data);

        $id = bin2hex(openssl_random_pseudo_bytes(16));
        $user->update(["id" => $id]);
        $this->users[$id] = $user;

        if (!$silent) {
            events()->trigger("users:created", $this, $user);
        }

        return $user;
    }

    public function updateUser(User $user, array $data, bool $silent = false): ?User
    {
        echo "UserRepository: Updating a user.\n";

        $id = $user->attributes["id"];
        if (!isset($this->users[$id])) {
            return null;
        }

        $user = $this->users[$id];
        $user->update($data);

        if (!$silent) {
            events()->trigger("users:updated", $this, $user);
        }

        return $user;
    }

    public function deleteUser(User $user, bool $silent = false): void
    {
        echo "UserRepository: Deleting a user.\n";

        $id = $user->attributes["id"];
        if (!isset($this->users[$id])) {
            return;
        }

        unset($this->users[$id]);

        if (!$silent) {
            events()->trigger("users:deleted", $this, $user);
        }
    }
}
