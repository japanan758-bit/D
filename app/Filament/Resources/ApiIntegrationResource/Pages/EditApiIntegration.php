<?php

namespace App\Filament\Resources\ApiIntegrationResource\Pages;

use App\Filament\Resources\ApiIntegrationResource;
use App\Services\IntegrationManager;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApiIntegration extends EditRecord
{
    protected static string $resource = ApiIntegrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('test')
                ->label('Test Integration')
                ->icon('heroicon-m-play')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Test Integration')
                ->modalDescription('This will test the integration to ensure it\'s working properly.')
                ->action(function () {
                    try {
                        $manager = app(IntegrationManager::class);
                        $service = $manager->getService($this->record->name);
                        
                        if ($service && $service->validate()) {
                            $result = $service->test();
                            
                            if ($result['success']) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Test Successful')
                                    ->body($result['message'])
                                    ->success()
                                    ->send();
                            } else {
                                \Filament\Notifications\Notification::make()
                                    ->title('Test Failed')
                                    ->body($result['message'])
                                    ->danger()
                                    ->send();
                            }
                        } else {
                            \Filament\Notifications\Notification::make()
                                ->title('Service Not Available')
                                ->body('The service is not properly configured')
                                ->warning()
                                ->send();
                        }
                    } catch (\Exception $e) {
                        \Filament\Notifications\Notification::make()
                            ->title('Test Error')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Actions\Action::make('activate')
                ->label($this->record->is_active ? 'Deactivate' : 'Activate')
                ->icon($this->record->is_active ? 'heroicon-m-x-circle' : 'heroicon-m-check-circle')
                ->color($this->record->is_active ? 'danger' : 'success')
                ->requiresConfirmation()
                ->modalHeading($this->record->is_active ? 'Deactivate Integration' : 'Activate Integration')
                ->action(function () {
                    $this->record->update(['is_active' => !$this->record->is_active]);
                    
                    \Filament\Notifications\Notification::make()
                        ->title($this->record->is_active ? 'Integration Activated' : 'Integration Deactivated')
                        ->success()
                        ->send();
                }),

            Actions\DeleteAction::make()
                ->label('Delete Integration')
                ->requiresConfirmation()
                ->modalHeading('Delete Integration')
                ->modalDescription('Are you sure you want to delete this integration? This action cannot be undone.')
                ->before(function () {
                    // Log the deletion attempt
                    \Log::info('API Integration deletion attempted', [
                        'integration' => $this->record->name,
                        'user' => auth()->user()->email ?? 'unknown'
                    ]);
                }),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Process API keys before saving
        if (isset($data['api_keys'])) {
            // The model's mutator will handle encryption
        }
        
        // Log the update attempt
        \Log::info('API Integration update attempted', [
            'integration' => $this->record->name,
            'changes' => $data,
            'user' => auth()->user()->email ?? 'unknown'
        ]);
        
        return $data;
    }

    protected function afterSave(): void
    {
        $manager = app(IntegrationManager::class);
        
        // Test the integration after saving
        if ($this->record->is_active) {
            try {
                $service = $manager->getService($this->record->name);
                if ($service && $service->validate()) {
                    $result = $service->test();
                    
                    // Log test result
                    \Log::info('Post-save integration test', [
                        'integration' => $this->record->name,
                        'test_result' => $result
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error('Post-save integration test failed', [
                    'integration' => $this->record->name,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        // Clear any cached services
        app(IntegrationManager::class)->loadActiveServices();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Integration updated successfully';
    }

    protected function getSaveNotificationTitle(): ?string
    {
        return 'Saving integration...';
    }

    protected function getDeleteNotificationTitle(): ?string
    {
        return 'Integration deleted';
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->label('Save Changes'),
            $this->getSaveAndCloseFormAction()
                ->label('Save & Close'),
            Actions\Action::make('reset')
                ->label('Reset')
                ->color('gray')
                ->outlined()
                ->action(function () {
                    $this->fillForm();
                }),
        ];
    }

    protected function fillForm(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function getTitle(): string
    {
        return "Edit {$this->record->display_name}";
    }

    protected function canDelete(Model $record): bool
    {
        return true;
    }

    protected function canView(Model $record): bool
    {
        return true;
    }

    protected function canForceDelete(Model $record): bool
    {
        return false; // Don't allow force delete to prevent data loss
    }
}