<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EnumRule implements Rule
{
  protected $enum;

  public function __construct($enum)
  {
    return $this->enum = $enum;
  }

  public function passes($attribute, $value): bool
  {
    return in_array($value, $this->enum);
  }
  public function message(): string
  {
    return 'The :attribute must be one of the following: ' . implode(', ', $this->enum);
  }
}
