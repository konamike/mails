<x-mail::message>
# From the Office of the MD/CEO of the NDDC
<b>Your document:

<x-mail::panel>
{{$message}}
</x-mail::panel>

<b>has been processed.

<x-mail::button :url="'http://www.nddc.gov.ng'" color="success">
Visit the NDDC Website
</x-mail::button>

Thank you, <br>
MD/CEO Mail Management System
</x-mail::message>
