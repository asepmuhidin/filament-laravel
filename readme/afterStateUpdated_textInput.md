# afterStateUpdated TextInput
`code`
use Filament\Forms\Set;
TextInput::make('name')
    ->live()
    ->afterStateUpdated(function(string $operation,$state, Set $set){
        if($operation !=='create){
            return
        }
        $set('slug',Str::slug($state))
    })