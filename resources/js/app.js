import './bootstrap';

import Alpine from 'alpinejs';

import Sortable from 'sortablejs';
import { Livewire } from 'livewire-sortable';

document.addEventListener('livewire:load', () => {
    const list = document.getElementById('task-list');
    Sortable.create(list, {
        animation: 150,
        handle: '[wire\\:sortable\\.handle]',
        onEnd: (evt) => {
            const orderedIds = Array.from(list.children).map((child) => child.getAttribute('wire:sortable.item'));
            Livewire.emit('updateTaskOrder', orderedIds);
        },
    });
});

window.Alpine = Alpine;

Alpine.start();
