const messages: Record<string, string> = {};

export function getMessages(): Readonly<Record<string, string>> {
    return messages;
}

export function addMessage(id: string, message: string): void {
    messages[id] = message;
}

export function addMessages(messages: Record<string, string>): void {
    Object.entries(messages).forEach(([key, value]) => {
        addMessage(key, value);
    });
}
