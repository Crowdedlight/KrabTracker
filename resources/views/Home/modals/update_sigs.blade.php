{!! BootForm::open()->post()->action(route('sig.update')) !!}
{!! BootForm::textarea('signatures', 'signatures')->rows(10)->placeholder('Make sure to copy all signatures into this box. ctrl+c in probescanner with no sigs ignored then ctrl+v here') !!}
{!! Button::submit()->primary()->withValue('Update')->block() !!}
{!! BootForm::close() !!}